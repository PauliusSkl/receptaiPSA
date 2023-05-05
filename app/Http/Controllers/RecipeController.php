<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Kitchen_Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductInfoAPI;
use App\Http\Controllers\SmartFridgeAPI;
use App\Http\Controllers\FoodRecognitionAI;
use function Symfony\Component\VarDumper\Dumper\esc;

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
        $time = 0;
        foreach ($products as $product_id) {
            $quantity = $quantities[$product_id];
            $recipe->products()->attach($product_id, ['quantity' => $quantity]);
            $time += 600;
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
        $recipe->preparation_time = $time;


        $calories = ProductInfoAPI::QueryList($products);
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

        //API call to get products in fridge
        $productsInFridge = SmartFridgeAPI::GetUserProducts();

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

    public function InitiateSelection($id)
    {
        $recipe = Recipe::with('products', 'tools', 'kitchen_categories')->find($id);
        return view('player.recipe.RecipePage', compact('recipe'));
    }

    public function StartRecipeCreation($id)
    {
        $user = User::find(Auth::id());
        $recipe = Recipe::with('products', 'tools', 'kitchen_categories')->find($id);
        //Check if user already has the recipe
        $userRecipes = $user->recipes()->pluck('recipe_id')->toArray();
        $time = $this->CalculateRecipeTime($id);
        $recipe->preparation_time = $time;
        $recipe->save();
        $timeleft = $time;
        if (in_array($id, $userRecipes)) {
            // $user->recipes()->detach($recipe);
            //Check start time modifie time left from start time
            $recipeStartTime = $user->recipes()->where('recipe_id', $id)->first()->pivot->start_time;
            $timeleft = $time - (now()->diffInSeconds($recipeStartTime));
            if ($timeleft <= 0) {
                $timeleft = 0;
            }
            return view('player.recipe.RecipeMakingPage', compact('recipe', 'timeleft'));
        }

        $user->recipes()->attach($recipe, [
            'status' => 'unfinished',
            'start_time' => now(),
        ]);

        return view('player.recipe.RecipeMakingPage', compact('recipe', 'timeleft'));
    }

    public function CalculateRecipeTime($id)
    {
        $recipe = Recipe::with('products', 'tools', 'kitchen_categories')->find($id);
        $products = $recipe->products;
        $time = 0;
        foreach ($products as $product) {
            $time += 600;
        }
        return $time;
    }

    public function StopRecipe($id, Request $request)
    {
        $user = User::find(Auth::id());
        $recipe = Recipe::with('products', 'tools', 'kitchen_categories')->find($id);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path('images'), $filename);
            //check if food
            $isFood = FoodRecognitionAI::CheckIfFood($filename);
            if ($isFood) {
                $user->recipes()->updateExistingPivot($id, [
                    'status' => 'finished',
                    'img' => $filename,
                ]);
            } else {
                $user->recipes()->updateExistingPivot($id, [
                    'status' => 'failed',
                    'img' => $filename,
                ]);
            }
        } else {
            $user->recipes()->updateExistingPivot($id, [
                'status' => 'failed',
            ]);
        }
        $ratingDiff = $this->CalculateRating($id);
        // $user->recipes()->detach($recipe);
        return redirect('/redirect')->with('error', 'rating updated successfully with ' . $ratingDiff . ' rating');
    }

    public function CalculateRating($id)
    {
        $user = User::find(Auth::id());
        $recipe = Recipe::with('products', 'tools', 'kitchen_categories')->find($id);
        //Check recipe status
        $recipeStatus = $user->recipes()->where('recipe_id', $id)->first()->pivot->status;
        $ratingToBeAdded = 0;
        if ($recipeStatus == 'finished') {
            $recipeRating = $recipe->rating;
            $userRating = $user->rating;

            $ratingDifference = $userRating - $recipeRating;
            if ($ratingDifference <= 0) {
                //Calculate time it took to make the recipe
                $recipeStartTime = $user->recipes()->where('recipe_id', $id)->first()->pivot->start_time;
                $time = $recipe->preparation_time;
                $timeleft = $time - (now()->diffInSeconds($recipeStartTime));
                $timeMultiplier = ($time / $timeleft)  + 1;
                $ratingToBeAdded = abs($ratingDifference * $timeMultiplier);
            } else {
                $ratingToBeAdded = abs($ratingDifference / 10);
            }
            $user->rating += $ratingToBeAdded;
            $recipe->save();
        } else {
            $recipeRating = $recipe->rating;
            $userRating = $user->rating;
            if ($userRating != 0) {
                $ratingDifference = $userRating - $recipeRating;
                if ($ratingDifference > 0) {
                    $ratingToBeAdded = $ratingDifference;
                } else {
                    $ratingToBeAdded = abs($ratingDifference / 10);
                }
                $user->rating -= $ratingToBeAdded;
                $recipe->save();
            }
        }
        $user->save();
        $user->recipes()->detach($recipe);

        if ($recipeStatus == 'failed') {
            return $ratingToBeAdded * -1;
        }
        return $ratingToBeAdded;
    }
}
