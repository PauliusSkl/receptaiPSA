<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kitchen_Category;
use App\Models\Tool;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function OpenUserCartPage()
    {

        return view('player.usercart');
    }
}
