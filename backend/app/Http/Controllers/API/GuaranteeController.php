<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guarantee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GuaranteeController extends Controller
{
    // Listar garantías del usuario autenticado
    public function index()
    {
        $garantias = Guarantee::with('product')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json($garantias);
    }

    // Crear una garantía manualmente (por ahora para pruebas)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $garantia = Guarantee::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return response()->json(['message' => 'Garantía creada', 'data' => $garantia], 201);
    }

    public function searchByOrder($orderId)
    {
        $guarantee = Guarantee::with('product')
            ->where('user_id', auth()->id())
            ->where('order_id', $orderId) // Si guardas la order_id
            ->first();

        if (!$guarantee) {
            return response()->json(['message' => 'No se encontró garantía'], 404);
        }

        return response()->json($guarantee);
    }

    // Eliminar garantía (si se implementa panel admin)
    public function destroy($id)
    {
        $garantia = Guarantee::find($id);

        if (!$garantia || $garantia->user_id !== Auth::id()) {
            return response()->json(['message' => 'Garantía no encontrada'], 404);
        }

        $garantia->delete();

        return response()->json(['message' => 'Garantía eliminada']);
    }
}
