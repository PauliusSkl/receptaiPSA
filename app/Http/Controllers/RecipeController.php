<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Recipe;
use App\Models\Product;
use App\Models\Kitchen_Category;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function OpenRecipeCreatePage()
    {
        $products = Product::all();

        $tools = Tool::all();

        $categories = Kitchen_Category::all();

        return view('player.recipe.create', compact('products', 'tools', 'categories'));
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

        $tools = $request->input('tools');

        foreach ($tools as $tool_id) {
            $recipe->tools()->attach($tool_id);
        }

        $categories = $request->input('categories');

        foreach ($categories as $category_id) {
            $recipe->kitchen_categories()->attach($category_id);
        }
        return redirect('/redirect')->with('status', 'Recipe created successfully');
    }

    public function OpenRecipeListPage()
    {

        # recipes with products and tools and categories
        $recipes = Recipe::with('products', 'tools', 'kitchen_categories')->get();

        // $recipes = Recipe::with('products')->get();
        return view('player.recipe.RecipeListPage', compact('recipes'));
    }
}
