<?php

namespace App\Http\Controllers;

use App\Courier;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index() {
        $transactions = Transaction::all();
        return view('transaction.index', ['transactions' => $transactions]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'courier' => 'required',
        ]);

        $cart = Auth::user()->cart;
        if($cart == null) {
            return redirect()->route('cart.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $courier = Courier::find($request->courier);
        if($courier == null) {
            return redirect()->route('cart.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'courier_id' => $request->courier,
        ]);

        foreach($cart->flowers as $flower) {
            $transaction->flowers()->attach($flower->id, ['qty' => $flower->pivot->qty]);
        }

        $cart->delete();
        return redirect()->route('flower.index')->with('success', 'Transaction success.');
    }
}
