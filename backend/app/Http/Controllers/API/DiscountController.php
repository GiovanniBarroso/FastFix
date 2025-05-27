<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Product;
use Carbon\Carbon;

class DiscountController extends Controller
{
    // 🧾 Ver todos los descuentos (admin)
    public function index()
    {
        return Discount::with('products')->orderByDesc('created_at')->get();
    }

    // ➕ Crear un nuevo descuento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:discounts',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'inicio' => 'required|date',
            'fin' => 'required|date|after:inicio',
            'activo' => 'required|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $discount = Discount::create($validated);

        if (!empty($validated['product_ids'])) {
            $discount->products()->attach($validated['product_ids']);
        }

        $this->recalcularPreciosProductos($discount);

        return response()->json(['message' => 'Descuento creado', 'data' => $discount->load('products')], 201);
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
            'inicio' => 'required|date',
            'fin' => 'required|date|after:inicio',
            'activo' => 'required|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $discount->update($validated);

        if (isset($validated['product_ids'])) {
            $discount->products()->sync($validated['product_ids']);
        }

        $this->recalcularPreciosProductos($discount);

        return response()->json(['message' => 'Descuento actualizado', 'data' => $discount->load('products')]);
    }

    // 🗑️ Eliminar descuento
    public function destroy($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Descuento no encontrado'], 404);
        }

        // Guardamos productos antes de eliminar relación
        $productos = $discount->products;

        $discount->products()->detach(); // muy importante
        $discount->delete();

        // Recalcular para productos afectados
        foreach ($productos as $product) {
            $this->recalcularPrecioProducto($product);
        }

        return response()->json(['message' => 'Descuento eliminado']);
    }

    // 🔁 Recalcula precio para todos los productos afectados por este descuento
    private function recalcularPreciosProductos($discount)
    {
        foreach ($discount->products as $product) {
            $this->recalcularPrecioProducto($product);
        }
    }

    // 🧮 Lógica individual para un producto
    private function recalcularPrecioProducto(Product $product)
    {
        $precio = $product->precio_base;
        $ahora = Carbon::now();

        $descuentosActivos = $product->discounts()
            ->where('activo', true)
            ->where(function ($q) use ($ahora) {
                $q->whereNull('inicio')->orWhere('inicio', '<=', $ahora);
            })
            ->where(function ($q) use ($ahora) {
                $q->whereNull('fin')->orWhere('fin', '>=', $ahora);
            })
            ->get();

        foreach ($descuentosActivos as $d) {
            if ($d->tipo === 'porcentaje') {
                $precio *= 1 - ($d->valor / 100);
            } elseif ($d->tipo === 'fijo') {
                $precio -= $d->valor;
            }
        }

        $product->update([
            'precio' => max(0, round($precio, 2))
        ]);
    }
}
