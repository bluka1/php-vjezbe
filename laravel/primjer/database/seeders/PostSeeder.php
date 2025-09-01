<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // ovo je ANTI PATTERN!!!!
      // ovaj kod je napisan samo zato što u ovom trenu nemamo nijedan model osim User modela
      DB::table('users')->insert([
        'name' => 'Ante Antić',
        'email' => 'ante@ante.com',
        'password' => bcrypt('1234')
      ]);
    }
}
