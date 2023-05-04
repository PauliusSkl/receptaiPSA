<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Kitchen_Category;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function OpenRecipeCreatePage()
    {
        $products = Product::all();

        $tools = Tool::all();

        $categories = Kitchen_Category::all();

        return view('player.recipe.create', compact('products', 'tools', 'categories'));
    }

    public function calculateRecipeCalories(array $products): int
    {
        $count = count($products);
        $calories = $count * 100;
        return $calories;
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
        // Calculate rating
        $rating = $recipe->calculateRating();

        // Set recipe rating
        $recipe->rating = $rating;
        $recipe->save();


        $calories = $this->calculateRecipeCalories($products);
        $recipe->calories = $calories;
        $recipe->save();

        return redirect('/redirect')->with('status', 'Recipe created successfully');
    }



    public function OpenRecipeListPage()
    {
        # recipes with products and tools and categories
        $recipes = Recipe::with('products', 'tools', 'kitchen_categories')->get();

        $recommendedRecipes = $this->getRecommendations(Auth::id());
        // $recipes = Recipe::with('products')->get();
        return view('player.recipe.RecipeListPage', compact('recipes', 'recommendedRecipes'));
    }


    public function getRecommendations($userId)
    {
        // Get the user's rating
        $userRating = User::find($userId)->rating;

        // Get the user's blocked products
        $userBlockedProducts = User::find($userId)->products()->pluck('product_id')->toArray();

        $userRating = User::find($userId)->rating;
        // $userRating = 3;
        $productsInFridge = $this->getSmartFridgeProducts();

        $recipes = Recipe::with('products', 'tools', 'kitchen_categories')
            ->where('rating', '>=', $userRating - 200)
            ->whereNotIn('id', function ($query) use ($userBlockedProducts) {
                $query->select('recipe_id')
                    ->from('product_recipe')
                    ->whereIn('product_id', $userBlockedProducts);
            })
            ->whereIn('id', function ($query) use ($productsInFridge) {
                $query->select('recipe_id')
                    ->from('product_recipe')
                    ->whereIn('product_id', $productsInFridge);
            })
            ->get();

        return $recipes;
    }

    public function getSmartFridgeProducts()
    {
        $productIds = Product::pluck('id')->toArray();
        shuffle($productIds);
        $randomProductIds = array_slice($productIds, 0, rand(1, count($productIds)));
        return $randomProductIds;
    }
}
