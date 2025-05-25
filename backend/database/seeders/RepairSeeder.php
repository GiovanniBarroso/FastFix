<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Repair;
use App\Models\User;

class RepairSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('role_id', 2)->get();

        $dispositivos = [
            ['Móvil', 'iPhone XS', 'Pantalla rota y batería hinchada'],
            ['Ordenador', 'HP Pavilion Gaming', 'No enciende, posible problema de placa base'],
            ['Tablet', 'iPad Air 4', 'Pantalla táctil no responde'],
            ['Consola', 'Nintendo Switch', 'No carga los juegos físicos'],
            ['Móvil', 'Samsung Galaxy S21', 'Puerto de carga dañado'],
            ['Ordenador', 'Asus TUF FX505', 'Reinicios aleatorios tras unos minutos'],
        ];

        foreach ($clientes as $cliente) {
            foreach (array_slice($dispositivos, 0, rand(1, 3)) as [$tipo, $modelo, $problema]) {
                $estado = ['pendiente', 'en progreso', 'terminado', 'entregado'][rand(0, 3)];
                $garantia = ['sin', '3m', '6m'][rand(0, 2)];
                $fechaGarantia = $garantia === 'sin' ? null : now()->subDays(rand(1, 30));

                Repair::create([
                    'user_id' => $cliente->id,
                    'device_type' => $tipo,
                    'nombre' => $modelo,
                    'problem_description' => $problema,
                    'repair_notes' => rand(0, 1) ? 'Reparación realizada con repuesto original.' : null,
                    'status' => $estado,
                    'garantia' => $garantia,
                    'fecha_garantia' => $fechaGarantia,
                    'repair_cost' => rand(50, 250),
                    'received_at' => now()->subDays(rand(2, 10)),
                    'delivered_at' => $estado === 'entregado' ? now()->subDays(rand(0, 2)) : null,
                ]);
            }
        }
    }
}
