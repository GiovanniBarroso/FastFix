<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart_' . Auth::id(), []);
        return response()->json(['cart' => array_values($cart)], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->id);
        $cartKey = 'cart_' . Auth::id();
        $cart = session()->get($cartKey, []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['cantidad'] += $request->cantidad;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => $product->precio,
                'imagen' => $product->imagen,
                'cantidad' => $request->cantidad
            ];
        }

        session()->put($cartKey, $cart);

        return response()->json(['message' => 'Producto agregado al carrito'], 201);
    }

    public function destroy($id)
    {
        $cartKey = 'cart_' . Auth::id();
        $cart = session()->get($cartKey, []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put($cartKey, $cart);
        }

        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }

    public function clear()
    {
        session()->forget('cart_' . Auth::id());
        return response()->json(['message' => 'Carrito vaciado'], 200);
    }
}
