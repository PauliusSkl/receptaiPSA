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

    public function similarRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'product_recipe', 'product_id', 'recipe_id')
            ->withPivot('product_id')
            ->groupBy('recipe_id')
            ->havingRaw('COUNT(*) = ?', [count($this->products)]);
    }
}
