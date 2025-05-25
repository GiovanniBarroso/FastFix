<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin principal
        User::create([
            'nombre' => 'Giovanni',
            'apellidos' => 'Barroso',
            'email' => 'admin@fastfix.com',
            'telefono' => '600000000',
            'password' => Hash::make('password'),
            'role_id' => 1, // Admin
            'email_verified_at' => now(),
            'fecha_registro' => now(),
        ]);

        // Clientes simulados
        $clientes = [
            ['Luis', 'Martínez'],
            ['Laura', 'Sánchez'],
            ['Carlos', 'Pérez'],
            ['Ana', 'López'],
            ['Javier', 'Fernández'],
            ['Sofía', 'García'],
            ['Diego', 'Hernández'],
            ['Marta', 'Romero'],
            ['Raúl', 'Torres'],
        ];

        foreach ($clientes as $i => [$nombre, $apellido]) {
            User::create([
                'nombre' => $nombre,
                'apellidos' => $apellido,
                'email' => strtolower($nombre) . '.' . strtolower($apellido) . '@fastfix.com',
                'telefono' => '61111' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role_id' => 2, // Cliente
                'email_verified_at' => now(),
                'fecha_registro' => now()->subDays(rand(1, 90)),
            ]);
        }
    }
}
