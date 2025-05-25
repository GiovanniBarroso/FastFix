<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Product;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('role_id', 2)->get();
        $productos = Product::all();

        foreach ($clientes as $cliente) {
            $favoritos = $productos->random(rand(1, 4));

            foreach ($favoritos as $producto) {
                Favorite::updateOrCreate([
                    'user_id' => $cliente->id,
                    'product_id' => $producto->id,
                ]);
            }
        }
    }
}
