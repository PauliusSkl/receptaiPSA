<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function OpenUserCartPage()
    {
        //Get cart by user id 
        $cart = Cart::where('user_id', Auth::id())->first();

        $cartItems = $cart->products;

        //Calculate total price
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->pivot->price;
        }

        return view('player.OrderCart.UserCart', compact('cartItems', 'totalPrice'));
    }

    public function DeleteProductFromCart($id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $cart->products()->wherePivot('id', $id)->detach();
        return redirect()->back()->with('error', 'Product removed from cart!');
    }
}
