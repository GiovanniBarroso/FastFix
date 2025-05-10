<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Obtener todos los pedidos del usuario autenticado
    public function index()
    {
        $orders = Order::with(['products']) // relación con productos
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($orders);
    }

    // Crear pedido desde el carrito actual
    public function store(Request $request)
    {
        $cartKey = 'cart_' . Auth::id();
        $cart = session()->get($cartKey, []);

        if (empty($cart)) {
            return response()->json(['error' => 'El carrito está vacío'], 400);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'estado' => 'pendiente',
                'total' => array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $cart)),
            ]);

            foreach ($cart as $item) {
                $order->products()->attach($item['id'], [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio']
                ]);

                // Actualizar stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock', $item['cantidad']);
                }
            }

            session()->forget($cartKey); // Vaciar carrito
            DB::commit();

            return response()->json(['message' => 'Pedido generado correctamente', 'order' => $order], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al generar el pedido'], 500);
        }
    }

    // Ver un pedido específico
    public function show($id)
    {
        $order = Order::with('products')
            ->where('user_id', Auth::id())
            ->find($id);

        if (!$order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($order);
    }
}
