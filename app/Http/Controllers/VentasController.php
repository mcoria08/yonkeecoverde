<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pieza;
use App\Models\Stock;
use App\Models\Unidad;
use App\Models\Sucursales;
use App\Models\Ventas;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::select('
                SELECT
                    VENT.id,
                    USR.name as vendedor,
                    CUS.name as customer,
                    SUC.nombre as sucursal,
                    VENT.fecha_venta,
                    VENT.subtotal,
                    VENT.iva,
                    VENT.total
                FROM ventas as VENT
                LEFT JOIN customers as CUS ON VENT.id_customer = CUS.id
                LEFT JOIN sucursales as SUC ON VENT.id_ubicacion = SUC.id
                LEFT JOIN users as USR ON VENT.id_usuario = USR.id
                ORDER BY VENT.id DESC
            ');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/ventas/'.$row->id.'/ver" class="edit btn btn-primary btn-sm">Ver</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('ventas');
    }


    public function new()
    {
        $stocks = Stock::select('*')->get();
        $customers = Customer::select('*')->get();
        $locations = Sucursales::select('*')->get();

        $user = Auth::user();
        //Cart::instance('yonkeecoverde')->restore($user->id);
        $cartContent = Cart::instance('yonkeecoverde')->content();

        //Cart::destroy();
        //Cart::remove('620d670d95f0419e35f9182695918c68');
        //dd($cartContent);

        return view('ventas-new', compact('stocks',  'customers', 'locations', 'cartContent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getSubTotal()
    {
        $subTotal = Cart::instance('yonkeecoverde')->subtotal();
        $iva = $subTotal * 0.16;
        $total = $subTotal + $iva;
        return response()->json(['subtotal' => $subTotal, 'iva' => $iva, 'total' => $total]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function addItemToSale(Request $request)
    {
        $user = Auth::user();
        $itemId = $request->input('item_id');
        $stock = Stock::find($itemId);

        // To restore a cart instance named 'yonkeecoverde'
        // Ya no es necesario puesto que se inicializa en el al momento de logearse
        //Cart::instance('yonkeecoverde')->restore($user->id);


        // Obtener el carrito actual de la sesión
        Cart::instance('yonkeecoverde')->add($itemId, $stock->part_name, 1, $stock->selling_price,
            ['marca' => $stock->car_brand, 'modelo' => $stock->car_model_compatibility, 'anio' => $stock->year_of_manufacture]
        )->associate('Products');

        // To store a cart instance named 'yonkeecoverde'
        //Cart::instance('yonkeecoverde')->store($user->id);

        // Get the rowId of the stored item
        $rowId = Cart::instance('yonkeecoverde')->search(function ($cartItem, $rowId) use ($itemId) {
            return $cartItem->id === $itemId;
        })->first();

        return response()->json(['message' => $rowId]);
    }


    public function getCartItems()
    {
        $user = Auth::user();
        Cart::instance('yonkeecoverde')->restore($user->id);
        return response()->json(Cart::instance('yonkeecoverde')->content());
    }


    /**
     * Display the specified resource.
     */
    public function show(Ventas $ventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ventas $ventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ventas $ventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ventas $ventas)
    {
        //
    }

    public function deleteArticle(Request $request)
    {
        $rowId = $request->input('rowId');

        //Cart::instance('yonkeecoverde')->remove($rowId);
        $cart = Cart::instance('yonkeecoverde')->content()->where('rowId',$rowId);
        if($cart->isNotEmpty()){
            Cart::instance('yonkeecoverde')->remove($rowId);
        }

        return response()->json(['message' => 'ok']);
    }

    public function seeCart()
    {
        $user = Auth::user();
        Cart::instance('yonkeecoverde')->restore($user->id);
        $cartContent = Cart::instance('yonkeecoverde')->content();
        echo '<pre>'.print_r($cartContent, true).'</pre>';
    }


    public function registerSale(Request $request)
    {
        $user = Auth::user();

        // Getting the submitted data
        $submittedData = $request->all();
        parse_str($submittedData['data'], $parsedData);

        $token = $parsedData['_token'];
        $nIdCustomer = $parsedData['txtCustomer'];
        $nIdLocation = $parsedData['txtLocation'];
        $txtPersonaQueRecibe = $parsedData['txtName'];

        $paymentType = $request->input('paymentType');
        $creditCardNumber = '';
        if ($paymentType==='credit'){
            if (empty($creditCardNumber)) {
                return response()->json(['message' => 'El número de referencia de pago es requerido']);
            }
            $creditCardNumber = $request->input('creditCardNumber');
        }

        // Getting the cart content
        $subTotal = Cart::instance('yonkeecoverde')->subtotal();
        $iva = $subTotal * 0.16;
        $total = $subTotal + $iva;

        $venta = new Ventas();
        $venta->id_usuario = $user->id;
        $venta->id_customer = $nIdCustomer;
        $venta->id_ubicacion = $nIdLocation;
        $venta->persona_recibe = $txtPersonaQueRecibe;
        $venta->fecha_venta = date('Y-m-d H:i:s');
        $venta->tipo_pago = $paymentType;
        $venta->referencia_pago = $creditCardNumber;
        $venta->subtotal = $subTotal;
        $venta->iva = $iva;
        $venta->total = $total;
        $venta->save();

        //Get the ID of the last inserted record
        $ventaId = $venta->id;

        //Store each item of the cart into the venta_articulos table
        Cart::instance('yonkeecoverde')->content()->each(function ($item) use ($ventaId) {
            DB::table('venta_articulos')->insert([
                'id_venta' => $ventaId,
                'id_stock' => $item->id,
                'cantidad' => $item->qty,
                'precio' => $item->price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        });

        //Change the status of the stock items to "Vendido"
        Cart::instance('yonkeecoverde')->content()->each(function ($item) {
            $stock = Stock::find($item->id);
            $stock->status = 'VENDIDO';
            $stock->save();
        });

        Cart::destroy();

        //

        toastr()->success('Venta Registrada', 'Mensaje');

        //redirect to a view with the id if the "venta" to show a receipt
        return response()->json(['message' => $ventaId]);
        //return redirect()->route('ventas.index');
    }


    public function showReceipt($nId){
        //Get the data of the sale
        $venta = $data = DB::select('
                SELECT
                    VENT.id,
                    USR.name as vendedor,
                    CUS.name as customer,
                    VENT.persona_recibe,
                    SUC.nombre as sucursal,
                    VENT.fecha_venta,
                    VENT.subtotal,
                    VENT.iva,
                    VENT.total,
                    VENT.fecha_venta,
                    VENT.tipo_pago,
                    VENT.referencia_pago
                FROM ventas as VENT
                LEFT JOIN customers as CUS ON VENT.id_customer = CUS.id
                LEFT JOIN sucursales as SUC ON VENT.id_ubicacion = SUC.id
                LEFT JOIN users as USR ON VENT.id_usuario = USR.id
                WHERE
									VENT.id ='.$nId);

        //Get the list of items of the sale
        $listItems = DB::select('
                SELECT
                    VENT.id,
                    STCK.part_name,
                    VENT.cantidad,
                    VENT.precio
                FROM
                    venta_articulos AS VENT
                    LEFT JOIN stocks AS STCK ON STCK.id = VENT.id_stock
                WHERE
                    VENT.id_venta=' . $nId);

        return view('recibo', compact('nId', 'venta', 'listItems'));
    }

}
