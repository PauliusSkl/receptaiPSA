<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

class AuthController extends Controller
{
    public function Update(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $user = User::findOrFail($user_id);

        $user->products()->attach($product_id);
        return redirect()->back()->with('error', 'Product added');
    }

    public function show(Request $request)
    {
        $products = Product::get();
        return view('profile.show', [
            'products' => $products,
            'request' => $request,
            'user' => $request->user(),
        ]);
    }

    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        $user->products()->detach($product->id);
        return redirect()->back()->with('error', 'Product deleted');
    }
}
