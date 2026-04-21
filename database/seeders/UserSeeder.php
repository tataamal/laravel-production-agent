<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Mamat Alkatiri",
            "email" => "mamat@example.com",
            "password" => Hash::make('Semarang123'),
        ]);
    }
}
