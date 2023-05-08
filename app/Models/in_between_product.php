<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class in_between_product extends Model
{
    protected $fillable = ['name', 'price', 'cart_id'];

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
