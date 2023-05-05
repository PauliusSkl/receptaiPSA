<?php

namespace App\Http\Controllers;

class ProductInfoAPI
{
    public static function QueryList(array $products): int
    {
        $count = count($products);
        $calories = $count * 100;
        return $calories;
    }
}
