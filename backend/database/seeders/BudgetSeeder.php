<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;
use App\Models\User;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('role_id', 2)->get();

        $mensajes = [
            'Hola, me gustaría saber cuánto costaría cambiar la batería de mi iPhone.',
            '¿Podrían darme un presupuesto para arreglar la pantalla de mi portátil?',
            'Tengo una consola PS5 que no enciende, ¿cuánto costaría revisarla?',
            '¿Qué precio tendría reparar el conector de carga de un Samsung Galaxy?',
            'Quiero cambiar la carcasa de mi tablet. ¿Ofrecen ese servicio?',
            '¿Hacen mantenimiento interno a PCs gaming? Me interesa una limpieza.',
        ];

        foreach ($clientes as $cliente) {
            foreach (array_slice($mensajes, 0, rand(1, 3)) as $i => $mensaje) {
                $estado = ['pendiente', 'respondido', 'rechazado'][rand(0, 2)];

                Budget::create([
                    'user_id' => $cliente->id,
                    'mensaje' => $mensaje,
                    'estado' => $estado,
                    'respuesta_admin' => $estado === 'respondido' ? 'Claro, el coste estimado sería entre 80€ y 120€, dependiendo del diagnóstico final.' : null,
                    'presupuesto_estimado' => $estado === 'respondido' ? rand(60, 150) : null,
                    'fecha_respuesta' => $estado === 'respondido' ? now()->subDays(rand(0, 5)) : null,
                ]);
            }
        }
    }
}
