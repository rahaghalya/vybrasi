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
            'username' => 'raha_admin', // TAMBAHAN: Wajib diisi karena migration meminta username
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'User Supervisor',
            'username' => 'supervisor_v', // TAMBAHAN: Wajib diisi karena migration meminta username
            'email' => 'spv@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => 2,
        ]);
    }
}