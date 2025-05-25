<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = User::where('role_id', 2)->get();
        $productos = Product::all();

        foreach ($clientes as $cliente) {
            for ($i = 0; $i < rand(1, 2); $i++) {
                $productosSeleccionados = $productos->random(rand(1, 3));
                $estado = ['pendiente', 'pagado', 'cancelado'][rand(0, 2)];
                $metodo = ['paypal', 'tarjeta', 'efectivo'][rand(0, 2)];

                $total = 0;
                $detalle = [];

                foreach ($productosSeleccionados as $producto) {
                    $cantidad = rand(1, 2);
                    $precio = $producto->precio;
                    $total += $precio * $cantidad;

                    $detalle[$producto->id] = [
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                    ];
                }

                $orden = Order::create([
                    'user_id' => $cliente->id,
                    'total' => $total,
                    'estado' => $estado,
                    'metodo_pago' => $metodo,
                    'paypal_payment_id' => $metodo === 'paypal' ? Str::uuid() : null,
                    'paypal_status' => $metodo === 'paypal' && $estado === 'pagado' ? 'COMPLETED' : null,
                    'fecha_pago' => $estado === 'pagado' ? now()->subDays(rand(0, 10)) : null,
                    'notas_cliente' => rand(0, 1) ? 'Gracias, por favor entregar lo antes posible.' : null,
                    'notas_admin' => rand(0, 1) ? 'Pedido procesado correctamente.' : null,
                ]);

                $orden->products()->attach($detalle);
            }
        }
    }
}
