<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'apellidos' => 'FastFix',
            'email' => 'admin@fastfix.com',
            'telefono' => '600000000',
            'password' => Hash::make('password'),
            'role_id' => 1, // admin
            'email_verified_at' => '2025-05-19 19:16:45',
            'fecha_registro' => now(),
        ]);

        User::create([
            'name' => 'Cliente',
            'apellidos' => '',
            'email' => 'cliente@fastfix.com',
            'telefono' => '611111111',
            'password' => Hash::make('password'),
            'role_id' => 2, // cliente
            'email_verified_at' => '2025-05-19 19:16:45',
            'fecha_registro' => now(),
        ]);
    }
}
