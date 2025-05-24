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

        if ($user->role?->name === 'admin') {
            // Si es admin, mostrar todos los pedidos con relaciones
            $orders = Order::with(['products', 'user', 'address', 'voucher', 'invoice'])
                ->latest()
                ->get();
        } else {
            // Usuario normal: solo sus pedidos
            $orders = Order::with(['products', 'address', 'voucher', 'invoice'])
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
        $cart = session()->get($cartKey, []);

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

            // ✅ Crear notificación
            Notification::create([
                'title' => 'Nuevo pedido realizado',
                'message' => 'El usuario "' . Auth::user()->name . '" ha realizado un nuevo pedido.',
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

    // ✅ Ver un pedido específico (usuario autenticado)
    public function show($id)
    {
        $user = Auth::user();

        $order = Order::with(['products', 'address', 'voucher', 'invoice'])
            ->where('id', $id)
            ->when($user->role?->name !== 'admin', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($order);
    }
}
