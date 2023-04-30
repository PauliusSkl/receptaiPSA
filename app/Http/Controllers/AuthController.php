<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Update(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $user = User::findOrFail($user_id);

        $user->products()->attach($product_id);
        return redirect()->back();
    }
}
