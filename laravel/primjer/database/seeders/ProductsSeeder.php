<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('products')->insert([
        'name' => 'car',
        'color' => 'red',
        'user_id' => 1
      ]);

      DB::table('products')->insert([
        'name' => 'computer',
        'color' => 'gray',
        'user_id' => 1
      ]);

      DB::table('products')->insert([
        'name' => 'ball',
        'color' => 'white',
        'user_id' => 1
      ]);
    }
}
