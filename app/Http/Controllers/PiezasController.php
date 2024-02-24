<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pieza;
use DataTables;

class PiezasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pieza::select('*')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/piezas/'.$row->id.'/ver" class="edit btn btn-primary btn-sm">Ver</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('piezas');
    }

    public function savePiece(Request $request)
    {
        //dd($request->all());
        $id = null;
        if ($request->has('id')) {
            $id = $request->input('id');
        }

        // Validation rules
        $rules = [
            'txtName' => 'required|min:5|max:100',
        ];

        // Custom error messages
        $messages = [
            'txtName.required' => 'Nombre de parte es requerido con al menos 5 caracteres.',
        ];

        // Aplicar reglas
        $validatedData = $request->validate($rules, $messages);

        // Asginar los valores del submit a cada campo correcpondiente
        $mapFields = [
            'txtName' => 'name',
        ];

        $mappedData = [];
        foreach ($mapFields as $requestKey => $dbField) {
            if (isset($validatedData[$requestKey])) {
                $mappedData[$dbField] = $validatedData[$requestKey];
            }
        }

        // Crear/update pieza
        if ($id) {
            // Update an existing record
            $stock = Pieza::find($id);

            $stock->update($mappedData);
        } else {
            // Create a new record
            $stock = Pieza::create($mappedData);
        }

        $msgAction = (!$id) ? 'Nueva Pieza Creada' : 'Pieza Actualizada';
        $stringRoute = 'piezas.index';

        toastr()->success($msgAction, 'Mensaje');
        return redirect()->route($stringRoute);
    }


    /**
     * Display the specified resource.
     */
    public function show($nId)
    {
        $pieza = Pieza::find($nId);

        return view('piezas-show', compact('pieza' ));
    }

}
