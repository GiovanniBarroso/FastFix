<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $estados = ['pendiente', 'respondido', 'rechazado'];

        // Clientes de prueba del 1 al 7
        foreach (range(1, 7) as $i) {
            Budget::create([
                'nombre' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'mensaje' => "Mensaje de prueba número $i.",
                'telefono' => '60012345' . rand(0, 9),
                'estado' => $estados[array_rand($estados)],
            ]);
        }

        // Correos reales de prueba adicionales
        Budget::create([
            'nombre' => 'Roberto Gómez López',
            'email' => 'robertogomezlopez2005@gmail.com',
            'mensaje' => 'Hola, soy Roberto. ¿Podéis ayudarme con una reparación?',
            'telefono' => '600123456',
            'estado' => 'pendiente',
        ]);

        Budget::create([
            'nombre' => 'Giovanni Barroso Álvarez',
            'email' => 'giovanni.baralv@gmail.com',
            'mensaje' => 'Me interesa un presupuesto para arreglar mi consola.',
            'telefono' => '600654321',
            'estado' => 'respondido',
        ]);

        Budget::create([
            'nombre' => 'Álvaro Rodríguez Amarillo',
            'email' => 'alvarorodriguezam22@alumnos.ilerna.com',
            'mensaje' => '¿Cuánto cuesta reparar un portátil HP?',
            'telefono' => '600987654',
            'estado' => 'pendiente',
        ]);
    }
}
