<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Kitchen_Category;
use App\Models\Product;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function OpenUserCartsPage()
    {
        $user = Auth::user();
        $cart = $user->carts; // retrieve the user's cart using the carts() relationship
        $inBetweenProducts = $cart->in_between_products();
        $products =  Product::get($inBetweenProducts);
        dd($products);
        return view('player.usercarts', compact('carts'));
    }
}
