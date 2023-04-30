<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function OpenRecipeCreatePage()
    {
        $products = Product::all();

        return view('player.recipe.create', compact('products'));
    }

    public function SubmitRecipeCreate(Request $request)
    {
        $recipe = Recipe::create([
            'name' => $request->input('name'),
            'preparation' => $request->input('preparation'),
        ]);

        $products = $request->input('products');
        $quantities = $request->input('quantities');

        foreach ($products as $product_id) {
            $quantity = $quantities[$product_id];
            $recipe->products()->attach($product_id, ['quantity' => $quantity]);
        }

        return redirect('/redirect')->with('status', 'Recipe created successfully');
    }

    public function OpenRecipeListPage()
    {
        $recipes = Recipe::with('products')->get();

        return view('player.recipe.RecipeListPage', compact('recipes'));
    }
}
