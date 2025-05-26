<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('role_id', 2)->get();

        $ciudades = [
            ['Madrid', 'Madrid'],
            ['Barcelona', 'Cataluña'],
            ['Sevilla', 'Andalucía'],
            ['Valencia', 'Comunidad Valenciana'],
            ['Bilbao', 'País Vasco'],
        ];

        foreach ($clientes as $cliente) {
            for ($i = 0; $i < rand(1, 2); $i++) {
                [$ciudad, $provincia] = $ciudades[array_rand($ciudades)];
                $principal = $i === 0;

                Address::create([
                    'user_id' => $cliente->id,
                    'nombre' => $cliente->nombre . ' ' . $cliente->apellidos,
                    'direccion' => 'Calle ' . chr(65 + rand(0, 25)) . ' Nº' . rand(1, 100),
                    'codigo_postal' => rand(10000, 52999),
                    'ciudad' => $ciudad,
                    'provincia' => $provincia,
                    'pais' => 'España',
                    'telefono_envio' => $cliente->telefono,
                    'principal' => $principal,
                ]);
            }
        }
    }
}
