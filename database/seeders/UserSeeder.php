<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // User default - hanya buat jika belum ada
        if (!User::where('email', 'user@gmail.com')->exists()) {
            User::create([
                'name' => 'User',
                'email' => 'user@gmail.com',
                'role' => 'user',
                'password' => Hash::make('user'),
            ]);
        }

        // Admin - hanya buat jika belum ada
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
        }

        // Akun Kasir - hanya buat jika belum ada
        if (!User::where('email', 'kasir1@gmail.com')->exists()) {
            User::create([
                'name' => 'Kasir 1',
                'email' => 'kasir1@gmail.com',
                'role' => 'cashier',
                'password' => Hash::make('kasir123'),
            ]);
        }

        if (!User::where('email', 'kasir2@gmail.com')->exists()) {
            User::create([
                'name' => 'Kasir 2',
                'email' => 'kasir2@gmail.com',
                'role' => 'cashier',
                'password' => Hash::make('kasir123'),
            ]);
        }
    }
}
