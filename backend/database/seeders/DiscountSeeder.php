<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Str;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $tipo = rand(0, 1) ? 'porcentaje' : 'fijo';
            $valor = $tipo === 'porcentaje' ? rand(10, 30) : rand(10, 50);

            $discount = Discount::create([
                'codigo' => Str::upper(Str::random(8)),
                'descripcion' => 'Descuento automático para varios productos',
                'activo' => true,
                'valor' => $valor,
                'tipo' => $tipo,
                'inicio' => now()->subDays(rand(0, 3)),
                'fin' => now()->addDays(rand(3, 10)),
            ]);

            // Asignar entre 1 y 4 productos aleatorios
            $productos = Product::inRandomOrder()->take(rand(1, 4))->pluck('id')->toArray();
            $discount->products()->attach($productos);
        }
    }
}

