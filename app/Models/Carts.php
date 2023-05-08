<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $fillable = ['kaina'];

    public function in_between_products()
    {
        return $this->hasOne(in_between_product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
