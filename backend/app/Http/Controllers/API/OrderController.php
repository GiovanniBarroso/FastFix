<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    // ✅ Obtener pedidos del usuario o todos si es admin
    public function index()
    {
        $user = Auth::user();

        if ($user->role?->nombre === 'admin') {
            $orders = Order::with(['products', 'user', 'address', 'invoice'])->latest()->get();
        } else {
            $orders = Order::with(['products', 'user', 'address', 'invoice'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }


        return response()->json($orders);
    }

    // ✅ Crear pedido desde el carrito de sesión
    public function store(Request $request)
    {
        $cartKey = 'cart_' . Auth::id();
        $cart = $request->input('productos', []);

        if (empty($cart)) {
            return response()->json(['error' => 'El carrito está vacío'], 400);
        }

        DB::beginTransaction();

        try {
            $total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $cart));

            $order = Order::create([
                'user_id' => Auth::id(),
                'estado' => 'pendiente',
                'total' => $total,
                'fecha_pedido' => Carbon::now(),
                'address_id' => $request->address_id ?? 1
            ]);

            foreach ($cart as $item) {
                $order->products()->attach($item['id'], [
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio']
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock', $item['cantidad']);
                }
            }

            session()->forget($cartKey);

            Notification::create([
                'title' => 'Nuevo pedido realizado',
                'message' => 'El usuario "' . Auth::user()->nombre . '" ha realizado un nuevo pedido.',
                'type' => 'pedido',
                'read' => false,
            ]);

            DB::commit();

            return response()->json(['message' => 'Pedido generado correctamente', 'order' => $order], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al generar el pedido', 'exception' => $e->getMessage()], 500);
        }
    }

    // ✅ Ver un pedido específico
    public function show($id)
    {
        $user = Auth::user();

        $order = Order::with(['products', 'user', 'address', 'invoice'])->find($id);

        if (!$order || ($user->role_id !== 1 && $order->user_id !== $user->id)) {
            return response()->json(['message' => 'Pedido no autorizado o no encontrado'], 403);
        }

        return response()->json($order);
    }
}
