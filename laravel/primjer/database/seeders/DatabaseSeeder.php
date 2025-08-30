<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'a@a.com',
            'password' => bcrypt('password'), // Ensure to hash the password
        ]
      );
        User::factory()->create([
            'name' => 'Pero',
            'email' => 'b@b.com',
            'password' => bcrypt('1234')
          ]
      );
    }
}