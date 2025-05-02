<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'activo' => 'required|boolean'
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'No encontrada'], 404);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'activo' => 'required|boolean'
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'No encontrada'], 404);

        $category->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }
}
