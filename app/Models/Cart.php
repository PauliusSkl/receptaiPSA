<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['price'];

    public function in_between_products()
    {
        return $this->hasMany('App\Models\InBetweenProduct');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
