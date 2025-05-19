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
            'role_id' => 1,
            'email_verified_at' => '2025-05-19 19:16:45'
        ]);

        User::create([
            'name' => 'Cliente-test',
            'email' => 'cliente@fastfix.com',
            'password' => Hash::make('password'),
            'role_id' => 2,// cliente
            'email_verified_at' => '2025-05-19 19:16:45'
        ]);
    }
}
