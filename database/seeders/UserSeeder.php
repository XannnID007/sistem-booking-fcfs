<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Admin No. 1, Bandung'
        ]);

        // Customer Demo 1
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Customer No. 1, Bandung'
        ]);

        // Customer Demo 2
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Customer No. 2, Bandung'
        ]);
    }
}
