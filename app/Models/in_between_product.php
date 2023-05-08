<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_between_product extends Model
{
    protected $table = 'product_recipe';

    protected $fillable = ['price'];

    public function carts()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'product_id');
    }
    public function recipe()
    {
        return $this->hasOne(Recipe::class, 'recipe_id');
    }
}
