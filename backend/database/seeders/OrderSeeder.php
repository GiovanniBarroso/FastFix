<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $address = Address::first();
        $products = Product::all();

        if (!$user || !$address || $products->isEmpty()) {
            dump('Faltan datos para crear pedidos');
            return;
        }

        foreach (range(1, 5) as $i) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'estado' => ['pendiente', 'enviado', 'pagado'][rand(0, 2)],
                'total' => 0,
                'fecha_pedido' => Carbon::now()->subDays($i),
            ]);

            $total = 0;
            foreach ($products->random(2) as $product) {
                $cantidad = rand(1, 3);
                $precio = $product->price;

                $order->products()->attach($product->id, [
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                ]);

                $total += $cantidad * $precio;
            }

            $order->update(['total' => $total]);
        }
    }
}
