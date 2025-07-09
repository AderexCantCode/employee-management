<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Tambahkan import User
use Illuminate\Support\Facades\Hash; // Tambahkan import Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Hash password
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Ade',
            'email' => 'ade@gmail.com',
            'password' => Hash::make('ade123'),
            'role' => 'employee',
            'email_verified_at' => now()
        ]);
    }
}
