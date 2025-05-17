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
            'email' => 'admin@fastfix.com',
            'password' => Hash::make('password'),
            'role_id' => 1 // admin
        ]);

        User::create([
            'name' => 'Cliente Test',
            'email' => 'cliente@fastfix.com',
            'password' => Hash::make('password'),
            'role_id' => 2 // cliente
        ]);
    }
}
