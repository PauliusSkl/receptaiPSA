<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserProductSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(2);

        $products = [
            [
                'name' => 'Flour',
                'score_multiplier' => 2.5,
            ],
            [
                'name' => 'Rice',
                'score_multiplier' => 1.5,
            ],
            [
                'name' => 'Meat',
                'score_multiplier' => 3.0,
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product($productData);
            $product->user()->associate($user);
            $product->save();
        }
    }
}
