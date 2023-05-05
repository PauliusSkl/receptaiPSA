<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SmartFridgeAPI
{
    public static function GetUserProducts()
    {
        $productIds = Product::pluck('id')->toArray();
        shuffle($productIds);
        $randomProductIds = array_slice($productIds, 0, rand(1, count($productIds)));
        return $randomProductIds;
    }
}
