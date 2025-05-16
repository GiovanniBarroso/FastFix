<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            dump('No hay usuarios. No se puede crear dirección.');
            return;
        }

        Address::create([
            'user_id' => $user->id,
            'calle' => 'Calle Falsa 123',
            'ciudad' => 'Madrid',
            'provincia' => 'Madrid',
            'codigo_postal' => '28080',
            'pais' => 'España',
        ]);
    }
}
