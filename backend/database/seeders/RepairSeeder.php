<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Repair;
use App\Models\User;
use Carbon\Carbon;

class RepairSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        Repair::insert([
            [
                'user_id' => $user->id,
                'device_type' => 'Móvil',
                'name' => 'iPhone 11',
                'problem_description' => 'Pantalla rota tras caída.',
                'repair_notes' => 'Se reemplazó pantalla completa. Pruebas OK.',
                'status' => 'terminado',
                'garantia' => '3m',
                'repair_cost' => 75.50,
                'received_at' => Carbon::now()->subDays(5),
                'delivered_at' => Carbon::now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'device_type' => 'Tablet',
                'name' => 'Galaxy Tab S6',
                'problem_description' => 'No carga correctamente.',
                'repair_notes' => 'Puerto de carga reemplazado.',
                'status' => 'entregado',
                'garantia' => '6m',
                'repair_cost' => 45.00,
                'received_at' => Carbon::now()->subDays(10),
                'delivered_at' => Carbon::now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'device_type' => 'Consola',
                'name' => 'Nintendo Switch',
                'problem_description' => 'Joystick se mueve solo (drift).',
                'repair_notes' => 'Se reemplazaron los joy-cons.',
                'status' => 'pendiente',
                'garantia' => 'sin',
                'repair_cost' => null,
                'received_at' => Carbon::now()->subDay(),
                'delivered_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
