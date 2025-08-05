<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 admin users
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Admin' . $i,
                'email' => 'admin' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create 7 normal users
        for ($i = 1; $i <= 7; $i++) {
            User::create([
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}