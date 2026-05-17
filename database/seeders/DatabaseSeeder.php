<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Memasukkan data dummy ke tabel roles
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'Supervisor'],
        ]);

        // 2. Memasukkan data dummy ke tabel users
        User::create([
            'name' => 'Raha Admin',
            'email' => 'admin@vybrasi.com',
            'password' => Hash::make('password123'), // Password diseragamkan
            'role_id' => 1, // Terhubung sebagai Admin
        ]);

        User::create([
            'name' => 'User Supervisor',
            'email' => 'spv@vybrasi.com',
            'password' => Hash::make('password123'), // Password diseragamkan
            'role_id' => 2, // Terhubung sebagai Supervisor
        ]);
    }
}