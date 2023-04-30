<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KitchenCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('kitchen__categories')->insert([
            [
                'name' => 'Austru',
                'score_multiplier' => 1.5,
            ],
            [
                'name' => 'Japonskiu',
                'score_multiplier' => 1.2,
            ],
            [
                'name' => 'Bagueciu',
                'score_multiplier' => 1.3,
            ],
        ]);
    }
}
