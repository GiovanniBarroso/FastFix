<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;
use App\Models\User;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::take(7)->get();

        foreach ($usuarios as $i => $user) {
            Budget::create([
                'user_id' => $user->id,
                'mensaje' => "Mensaje de prueba número " . ($i + 1),
                'estado' => 'pendiente',
            ]);
        }
    }
}
