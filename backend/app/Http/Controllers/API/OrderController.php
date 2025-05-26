<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
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

    public function store(Request $request)
    {
        $userId = Auth::id();

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            logger('🛒 El carrito está vacío para el usuario ID: ' . $userId);
            return response()->json(['error' => 'El carrito está vacío'], 400);
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cartItems as $item) {
                if (!$item->product) {
                    logger("❌ Producto no encontrado para CartItem ID: {$item->id}");
                    return response()->json(['error' => 'Producto no encontrado en el carrito'], 400);
                }

                $precio = $item->product->precio ?? 0;
                $cantidad = $item->cantidad ?? 0;

                if ($precio <= 0 || $cantidad <= 0) {
                    logger("⚠️ Precio o cantidad inválidos. Precio: $precio | Cantidad: $cantidad | Producto ID: {$item->product->id}");
                    return response()->json(['error' => 'Producto con datos inválidos en el carrito'], 400);
                }

                $total += $precio * $cantidad;
            }

            logger("📝 Creando pedido para el usuario ID: $userId con total: $total");

            $order = Order::create([
                'user_id' => $userId,
                'estado' => 'pendiente',
                'total' => $total,
                'fecha_pedido' => Carbon::now(),
                'address_id' => $request->address_id ?? 1
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;

                $order->products()->attach($product->id, [
                    'cantidad' => $item->cantidad,
                    'precio' => $product->precio
                ]);

                $product->decrement('stock', $item->cantidad);
            }

            // Limpiar el carrito
            CartItem::where('user_id', $userId)->delete();

            Notification::create([
                'title' => 'Nuevo pedido realizado',
                'message' => 'El usuario "' . Auth::user()->nombre . '" ha realizado un nuevo pedido.',
                'type' => 'pedido',
                'read' => false,
            ]);

            DB::commit();

            logger("✅ Pedido generado con éxito. ID: {$order->id}");
            return response()->json(['message' => 'Pedido generado correctamente', 'order' => $order], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('❌ Error al generar pedido: ' . $e->getMessage());
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
