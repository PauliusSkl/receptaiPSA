<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'preparation',
        'rating',
        'calories',
        'preparation_time',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'string',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class);
    }

    public function kitchen_categories()
    {
        return $this->belongsToMany(Kitchen_Category::class);
    }

    public function similarRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'product_recipe', 'product_id', 'recipe_id')
            ->withPivot('product_id')
            ->groupBy('recipe_id')
            ->havingRaw('COUNT(*) = ?', [count($this->products)]);
    }

    public function calculateRating()
    {
        $preparation = $this->preparation;
        $wordCount = str_word_count($preparation);
        $productMultipliers = $this->products()->sum('score_multiplier');
        $toolMultipliers = $this->tools()->sum('score_multiplier');
        $kitchenMultipliers = $this->kitchen_categories()->sum('score_multiplier');
        // Add up the multipliers and multiply by the word count
        $multiplierSum = $productMultipliers + $toolMultipliers + $kitchenMultipliers;
        $multiplierProduct = $multiplierSum * $wordCount;
        // Return the calculated rating
        return round($multiplierProduct, 2);
    }
}
