<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashBox;
use Illuminate\Support\Facades\Auth;

class CashBoxController extends Controller
{
    public function openCashBox(request $request)
    {
        //Get the amount from request
        $amount = $request->amount;

        $cashBox = new CashBox();
        $cashBox->opened_at = now();
        $cashBox->status = 'open';
        $cashBox->initial_amount = $amount;
        $cashBox->opened_by = auth()->id();
        $cashBox->save();

        toastr()->success('Apertura de caja exitoso', 'Mensaje');

        return response()->json(['message' => 'Cash box opened successfully'], 200);
    }

    public function closeCashBox()
    {
        $user_id = Auth::id();

        //Get the final amount of day
        $nTotalAmount = (new VentasController)->getFinalAmount();

        $cashBox = CashBox::whereNull('closed_at')
            ->where('opened_by', $user_id)
            ->latest()
            ->first();

        if ($cashBox) {
            $cashBox->closed_at = now();
            $cashBox->status = 'closed';
            $cashBox->closed_by = auth()->id();
            $cashBox->final_amount = $nTotalAmount;
            $cashBox->save();

            toastr()->success('Cierre de caja exitoso', 'Mensaje');
            return redirect()->route('ventas.index');
        } else {
            toastr()->error('No se puede cerrar la caja', 'Mensaje');
            return redirect()->route('ventas.index');
        }

    }

    public function checkCashBoxStatus()
    {
        $user_id = Auth::id();
        $cashBox = CashBox::whereNull('closed_at')
            ->where('opened_by', $user_id)
            ->latest()
            ->first();

        if ($cashBox) {
            return response()->json(['status' => 'open', 'opened_at' => $cashBox->opened_at], 200);
        } else {
            return response()->json(['status' => 'closed'], 200);
        }
    }


}
