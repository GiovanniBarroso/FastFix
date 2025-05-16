<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $estados = ['pendiente', 'respondido', 'rechazado'];

        foreach (range(1, 10) as $i) {
            Budget::create([
                'nombre' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'mensaje' => "Mensaje de prueba número $i.",
                'telefono' => '60012345' . rand(0, 9),
                'estado' => $estados[array_rand($estados)],
            ]);
        }
    }
}
