<?php

namespace App\Http\Controllers;


class FoodRecognitionAI
{
    public static function CheckIfFood($photo)
    {
        //return true with 95% chance
        $random = rand(1, 100);
        if ($random <= 95) {
            return true;
        }
        return false;
    }
}
