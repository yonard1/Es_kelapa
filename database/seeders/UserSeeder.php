<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun admin
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('12345'),
            'hak' => 'admin',
        ]);

        // Membuat akun kasir
        User::create([
            'name' => 'Kasir Utama',
            'username' => 'kasir',
            'password' => Hash::make('12345'),
            'hak' => 'kasir',
        ]);
    }
}
