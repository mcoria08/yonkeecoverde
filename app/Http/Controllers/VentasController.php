<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pieza;
use App\Models\Stock;
use App\Models\Unidad;
use App\Models\Sucursales;
use App\Models\Ventas;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
                    STK.part_name,
                    CUS.name as customer,
                    SUC.nombre as sucursal,
                    VENT.fecha_venta,
                    VENT.subtotal,
                    VENT.iva,
                    VENT.total
                FROM ventas as VENT
                LEFT JOIN stocks as STK ON VENT.id_stock = STK.id
                LEFT JOIN customers as CUS ON VENT.id_customer = CUS.id
                LEFT JOIN sucursales as SUC ON VENT.id = SUC.id
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
        return view('ventas-new', compact('stocks',  'customers', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

       /* if (session()->has($user->email)) {
            echo 'existe';
            $pendingSaleItems = session()->get($user->email);
            $pendingSaleItems[] = $itemId;
            session()->push($user->email, $itemId);
        } else {
            echo 'no existe';
            session()->put($user->email, $itemId);
        }*/

//        $request->session()->push('pending_sale_items', $itemId);

        //echo isset($cart[$itemId]) ? 'existe '.$itemId : 'no existe '. $itemId;

        # Init cart if not yet set
        /*if(!session()->has('cart')) {
            session()->put('cart', []);
            session()->flash('cart');
        }
        $cart = session('cart');
        if(isset($cart[$itemId])){
            # Pull and delete the old value
            $product = session()->pull("cart.{$itemId}", "cart.{$itemId}");
            # If we managed to pull anything, lets increase the quantity
            if(isset($product)) {
                $product[0]['quantity']++;
                session()->push("cart.{$itemId}", $product[0]);
                session()->reFlash('cart');
            }
        } else {
            # Nothing was pulled, lets add it
            session()->push("cart.{$itemId}",  [
                'productName'   => 'Product Name'.$itemId,
                'quantity'      => 1
            ]);
            session()->reFlash('cart');
        }*/

        if(!Session::has('cart')) {
            Session::put('cart', []);
            Session::flash('cart');
        }

        if ( Session::has('cart')) {
            $cart = Session::get('cart');

            // Ensure $cart is an array
            if (!is_array($cart)) {
                // Handle the case where $cart is not an array (this shouldn't happen under normal circumstances)
                // For example, you can reset $cart to an empty array
                $cart = [];
            }

            if (isset($cart[$itemId])) {
                $cart[$itemId]['quantity']++;
            } else {
                $cart[$itemId] = [
                    'quantity' => 1,
                    'item' => $itemId
                ];
            }
            Session::push('cart', $cart);
            Session::reFlash('cart');
        } else {
            $cart = [
                $itemId => [
                    'quantity' => 1,
                    'item' => $itemId
                ]
            ];
            Session::put('cart', $cart);
            Session::flash('cart');
        }

        dd(session());
        return response()->json(['message' => 'ok']);
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
}
