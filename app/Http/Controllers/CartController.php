<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Courier;
use App\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() {
        $cart = Auth::user()->cart;

        if($cart == null) {
            return view('cart.index');
        }

        $flowers = $cart->flowers;
        return view('cart.index', ['flowers' => $flowers, 'couriers' => Courier::all()]);
    }

    public function add_item(Request $request, $id) {
        $this->validate($request, [
            'quantity' => 'required|numeric|gt:0',
        ]);

        $flower = Flower::find($id);
        if($flower == null) {
            return redirect()->route('flower.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $cart = Auth::user()->cart;
        if($cart == null) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
            ]);
        }
        
        $cart_flower = $cart->flowers->where('id', $id)->first();
        if($cart_flower == null) {
            $cart->flowers()->attach($id, ['qty' => $request->quantity]);
        }
        else{
            $cart_flower->pivot->qty += $request->quantity;
            $cart_flower->pivot->save();
        }
        return redirect()->route('flower.index')
            ->with('success', $request->quantity.'x '.$flower->name.' added to cart.');
    }

    public function delete_item($id) {
        $cart = Auth::user()->cart;

        $flower = Flower::find($id);
        if($flower == null) {
            return redirect()->route('cart.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $cart->flowers()->detach($id);

        if($cart->flowers->count() == 0) {
            $cart->delete();
        }

        return redirect()->route('cart.index')->with('success', $flower->name.' removed from cart.');
    }
}
