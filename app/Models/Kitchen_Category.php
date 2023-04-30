<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen_Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'score_multiplier',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
