<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    // 🧾 Ver todos los descuentos (admin)
    public function index()
    {
        return Discount::with('product')->orderByDesc('created_at')->get();
    }

    // ➕ Crear un nuevo descuento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:discounts',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'product_id' => 'required|exists:products,id',
            'activo' => 'required|boolean'
        ]);

        $discount = Discount::create($validated);

        return response()->json(['message' => 'Descuento creado', 'data' => $discount], 201);
    }

    // ✏️ Actualizar un descuento
    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:discounts,codigo,' . $id,
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'product_id' => 'required|exists:products,id',
            'activo' => 'required|boolean'
        ]);

        $discount->update($validated);

        return response()->json(['message' => 'Descuento actualizado', 'data' => $discount]);
    }

    // 🗑️ Eliminar descuento
    public function destroy($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        $discount->delete();

        return response()->json(['message' => 'Descuento eliminado']);
    }
}
