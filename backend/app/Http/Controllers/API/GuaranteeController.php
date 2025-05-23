<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guarantee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GuaranteeController extends Controller
{
    // ✅ Listar garantías del usuario o admin
    public function index()
    {
        $user = Auth::user();

        // Si es admin, devuelve todas las garantías con usuario y producto
        if ($user->role_id === 1) {
            $garantias = Guarantee::with(['product', 'user'])
                ->orderByDesc('created_at')
                ->get();
        } else {
            // Si es cliente, solo sus garantías
            $garantias = Guarantee::with('product')
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
        }

        return response()->json($garantias);
    }

    // ✅ Crear una garantía
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $garantia = Guarantee::create([
            'user_id' => $request->user_id, // ⬅️ Usa el user_id recibido
            'product_id' => $request->product_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return response()->json(['message' => 'Garantía creada', 'data' => $garantia], 201);
    }


    // ✅ Buscar garantía por producto (mejor que por order_id si no se usa)
    public function searchByProduct($productId)
    {
        $garantia = Guarantee::with('product')
            ->where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$garantia) {
            return response()->json(['message' => 'No se encontró garantía'], 404);
        }

        return response()->json($garantia);
    }

    public function update(Request $request, $id)
{
    $garantia = Guarantee::find($id);

    if (!$garantia) {
        return response()->json(['message' => 'Garantía no encontrada'], 404);
    }

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'product_id' => 'required|exists:products,id',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after:fecha_inicio'
    ]);

    $garantia->update([
        'user_id' => $request->user_id,
        'product_id' => $request->product_id,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
    ]);

    return response()->json(['message' => 'Garantía actualizada', 'data' => $garantia]);
}


    // ✅ Eliminar garantía (admin o propietario)
    public function destroy($id)
    {
        $garantia = Guarantee::find($id);

        if (
            !$garantia ||
            (Auth::user()->role_id !== 1 && $garantia->user_id !== Auth::id())
        ) {
            return response()->json(['message' => 'Garantía no encontrada'], 404);
        }

        $garantia->delete();

        return response()->json(['message' => 'Garantía eliminada']);
    }
}
