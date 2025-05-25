<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Carbon;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Product::inRandomOrder()->take(4)->get();

        foreach ($productos as $producto) {
            $tipo = rand(0, 1) ? 'porcentaje' : 'fijo';
            $valor = $tipo === 'porcentaje' ? rand(10, 30) : rand(10, 50);

            Discount::create([
                'product_id' => $producto->id,
                'valor' => $valor,
                'tipo' => $tipo,
                'inicio' => now()->subDays(rand(0, 3)),
                'fin' => now()->addDays(rand(3, 10)),
            ]);
        }
    }
}
