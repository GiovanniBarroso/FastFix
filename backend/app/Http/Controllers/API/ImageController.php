<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Product;

class ImageController extends Controller
{
    // ✅ Listar imágenes por producto
    public function index($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($product->images);
    }

    // ✅ Subir imagen (desde URL externa por ahora)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'alt_text' => 'nullable|string|max:255',
            'product_id' => 'required|exists:products,id'
        ]);

        $image = Image::create($validated);

        return response()->json(['message' => 'Imagen subida', 'data' => $image], 201);
    }

    // ✅ Eliminar imagen
    public function destroy($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Imagen eliminada']);
    }
}
