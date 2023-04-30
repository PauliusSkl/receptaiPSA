<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tools')->insert([
            [
                'name' => 'Knife',
                'score_multiplier' => 1.5,
            ],
            [
                'name' => 'Spatula',
                'score_multiplier' => 1.2,
            ],
            [
                'name' => 'Whisk',
                'score_multiplier' => 1.3,
            ],
        ]);
    }
}
