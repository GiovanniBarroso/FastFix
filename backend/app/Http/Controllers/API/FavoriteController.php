<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', auth()->id())
            ->get()
            ->filter(fn($fav) => $fav->product) // evitar productos null
            ->map(function ($fav) {
                return [
                    'id' => $fav->id,
                    'product' => [
                        'id' => $fav->product->id,
                        'nombre' => $fav->product->nombre,
                        'descripcion' => $fav->product->descripcion,
                        'precio' => $fav->product->precio,
                        'imagen' => $fav->product->imagen,
                        'brand' => optional($fav->product->brand)->nombre ?? 'Sin marca',
                    ]
                ];
            });

        return response()->json(['favorites' => $favorites->values()], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $exists = Favorite::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Ya está en favoritos'], 200);
        }

        $favorite = Favorite::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id']
        ]);

        return response()->json($favorite, 201);
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$favorite)
            return response()->json(['message' => 'Favorito no encontrado'], 404);

        $favorite->delete();
        return response()->json(['message' => 'Favorito eliminado'], 200);
    }
}
