<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'user@email.com',
            'password' => Hash::make('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@email.com',
            'password' => Hash::make('12345678'),
            'usertype' => '1',
        ]);
    }
}
