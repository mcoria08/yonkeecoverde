<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Unidad;
use App\Models\Pieza;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Stock::select('*')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/stock/'.$row->id.'/ver" class="edit btn btn-primary btn-sm">Ver</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('stock');
    }

    public function new()
    {
        $unidades = Unidad::select('*')->get();
        $piezas = Pieza::select('*')->get();
        return view('stock-new', compact('unidades', 'piezas'));
    }

    public function saveUnit(Request $request)
    {
        //dd($request->all());
        $id = null;
        if ($request->has('id')) {
            $id = $request->input('id');
        }

        // Validation rules
        $rules = [
            'txtPartNumber' => 'required|min:5|max:50',
            'txtVenta' => 'required|numeric|between:0,999999.99',
            'txtCondition' => 'required|min:5|max:250',
        ];

        // Custom error messages
        $messages = [
            'txtPartNumber.required' => '# de parte es requerido con al menos 5 caracteres.',
            'txtVenta.required' => 'Precio de centa es requerido.',
            'txtCondition.required' => 'Detalles es requerido con al menos 5 caracteres.',
        ];

        // Aplicar reglas
        $validatedData = $request->validate($rules, $messages);

        // Asginar los valores del submit a cada campo correcpondiente
        $mapFields = [
            'txtPartNumber' => 'part_number',
            'txtVenta' => 'selling_price',
            'txtCondition' => 'condition',
        ];

        $mappedData = [];
        foreach ($mapFields as $requestKey => $dbField) {
            if (isset($validatedData[$requestKey])) {
                $mappedData[$dbField] = $validatedData[$requestKey];
            }
        }

        // Tomar el registro de la unidad
        $idUnidad = $request->input('txtUnidad');
        $unidad = Unidad::find($idUnidad);

        // Los siguientes 3 campos no son necesarios agregarlos a la base de datos, se están repitiendo
        // Pero lo estoy haciendo por el tema del dataTable
        $mappedData['car_brand'] = $unidad->marca;
        $mappedData['car_model_compatibility'] = $unidad->modelo;
        $mappedData['year_of_manufacture'] = $unidad->anio;

        // Tomar el registro de la pieza
        $idPieza = $request->input('txtPartName');
        $pieza = Pieza::find($idPieza);

        // El siguiente no es necesario agregarlo a la base de datos, se está repitiendo
        // Pero lo estoy haciendo por el tema del dataTable
        $mappedData['part_name'] = $pieza->name;

        // Agregando los valores del dropdown
        $mappedData['id_unidad'] = $request->input('txtTypeUSer');
        $mappedData['id_pieza'] = $request->input('txtPartName');

        // Crear/update pieza
        if ($id) {
            // Update an existing record
            $stock = Stock::find($id);

            $stock->update($mappedData);
        } else {
            // Create a new record
            $stock = Stock::create($mappedData);
        }

        $msgAction = (!$id) ? 'Nueva Pieza Creada' : 'Pieza Actualizada';
        $stringRoute = 'stock.index';

        toastr()->success($msgAction, 'Mensaje');
        return redirect()->route($stringRoute);
    }

    /**
     * Display the specified resource.
     */
    public function show($nId)
    {
        $stock = Stock::find($nId);
        $unidades = Unidad::select('*')->get();
        $piezas = Pieza::select('*')->get();

        $auto = Unidad::find($stock?->id_unidad);

        return view('stock-show', compact('stock', 'unidades', 'piezas', 'auto'));
    }

    public function getCarData(Request $request)
    {
        $id = $request->input('unidad_id');
        $unidad = Unidad::find($id);
        return response()->json($unidad);
    }

    public function getStockData(Request $request)
    {
        $id = $request->input('stock_id');

        // look for the id in the cart content to avoid duplicates
        $duplicated = false;
        Cart::instance('yonkeecoverde')->content()->each(function ($item) use ($id, &$duplicated) {
            if ($item->id === $id) {
                $duplicated = true;
            }
        });

        if ($duplicated === true) {
            return response()->json('duplicated');
        } else {
            $stock = DB::select("SELECT
                    st.id, st.id_unidad, st.id_pieza, st.part_name, st.part_number, st.location_in_stock, FORMAT(st.selling_price, 2) as selling_price,
                    uni.unidad, uni.modelo, uni.anio, uni.motor, uni.marca
                FROM
                    stocks AS st
                LEFT JOIN unidads AS uni ON uni.id=st.id_unidad
                WHERE
                    st.id=$id AND st.status='AVAILABLE'
                        ");
            return response()->json($stock);
        }
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $stocks = DB::select("
SELECT
	st.id, st.id_unidad, st.id_pieza, st.part_name, st.part_number, st.location_in_stock, FORMAT(st.selling_price, 2) as selling_price,
	uni.unidad, uni.modelo, uni.anio, uni.motor
FROM
	stocks AS st
LEFT JOIN unidads AS uni ON uni.id=st.id_unidad
WHERE
	st.part_name LIKE '%$search%' AND st.status='AVAILABLE'");
        return response()->json($stocks);
    }

}
