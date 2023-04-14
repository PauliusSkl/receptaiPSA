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
    ];

    //Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Get oweners name by user id
    public function getOwnerName()
    {
        return $this->user->name;
    }
}
