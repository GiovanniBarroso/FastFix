<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return Brand::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'activo' => 'required|boolean'
        ]);

        $brand = Brand::create($validated);
        return response()->json($brand, 201);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return response()->json(['message' => 'No encontrada'], 404);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'activo' => 'required|boolean'
        ]);

        $brand->update($validated);
        return response()->json($brand);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return response()->json(['message' => 'No encontrada'], 404);

        $brand->delete();
        return response()->json(['message' => 'Marca eliminada']);
    }
}
