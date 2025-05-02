<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        return Favorite::with(['product'])->where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $favorite = Favorite::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id']
        ]);

        return response()->json($favorite, 201);
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$favorite)
            return response()->json(['message' => 'Favorito no encontrado'], 404);

        $favorite->delete();
        return response()->json(['message' => 'Favorito eliminado']);
    }
}
