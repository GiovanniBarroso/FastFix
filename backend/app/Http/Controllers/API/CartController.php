<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        logger('🛒 GET /cart llamado por el usuario ID: ' . $userId);

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        logger('📦 Resultado con relaciones cargadas:', $cartItems->toArray());

        $formatted = $cartItems
            ->filter(fn($item) => $item->product) // evita nulls
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'product' => [
                        'id' => $item->product->id,
                        'nombre' => $item->product->nombre,
                        'price' => $item->product->price,
                        'image' => $item->product->image,
                        'brand' => optional($item->product->brand)->nombre ?? 'Sin marca'
                    ]
                ];
            })->values();

        logger('🧾 Carrito enviado a Vue:', $formatted->toArray());

        return response()->json(['cart' => $formatted], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['message' => 'Cantidad actualizada']);
    }

    public function store(Request $request)
    {
        logger('📦 POST /cart añadido por el usuario ID: ' . Auth::id());
        $request->validate([
            'id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $productId = $request->id;

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->cantidad;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $request->cantidad,
            ]);
        }

        return response()->json(['message' => 'Producto agregado al carrito'], 201);
    }

    public function destroy($id)
    {
        CartItem::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }

    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Carrito vaciado'], 200);
    }
}
