<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;

class CartItemsSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('role_id', 2)->get();
        $productos = Product::all();

        foreach ($clientes as $cliente) {
            if (rand(0, 1)) {
                $seleccionados = $productos->random(rand(1, 3));

                foreach ($seleccionados as $producto) {
                    CartItem::updateOrCreate([
                        'user_id' => $cliente->id,
                        'product_id' => $producto->id,
                    ], [
                        'cantidad' => rand(1, 2),
                    ]);
                }
            }
        }
    }
}
