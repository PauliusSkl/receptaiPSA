<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'score_multiplier',
        'user_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'string',
    ];

    //Relationship to User who created the product
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // Relationship to user who selected it as unwanted product
    public function users()
    {
        return $this->belongsToMany(User::class, 'blocked_product');
    }
    // Get oweners name by user id
    public function getOwnerName()
    {
        return $this->user->name;
    }

    // Produkta receptui
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
