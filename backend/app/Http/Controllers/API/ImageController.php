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

    // ✅ Subir imagen (archivo o URL externa)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // subida local
            'url' => 'nullable|url', // url externa
        ]);

        // Si viene un archivo, lo movemos y generamos la URL
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $validated['url'] = '/images/' . $filename;
        }

        // Si no hay ni archivo ni URL, error
        if (!isset($validated['url'])) {
            return response()->json(['message' => 'Debes enviar una imagen o una URL'], 422);
        }

        $image = Image::create([
            'product_id' => $validated['product_id'],
            'url' => $validated['url'],
            'alt_text' => $validated['alt_text'] ?? null,
        ]);

        return response()->json(['message' => 'Imagen subida', 'data' => $image], 201);
    }

    // ✅ Eliminar imagen (solo de la base de datos)
    public function destroy($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        // ❌ NO se borra el archivo físico, como pidió el usuario
        $image->delete();

        return response()->json(['message' => 'Imagen eliminada de la base de datos (el archivo se conserva)']);
    }
}
