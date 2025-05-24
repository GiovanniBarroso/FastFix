<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guarantee;
use Illuminate\Support\Facades\Auth;

class GuaranteeController extends Controller
{
    // Listar garantías del usuario o admin
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id === 1) {
            // Admin: todas las garantías con reparación y usuario
            $garantias = Guarantee::with(['repair.user'])->orderByDesc('created_at')->get();
        } else {
            // Cliente: solo sus garantías
            $garantias = Guarantee::with('repair')
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
        }

        return response()->json($garantias);
    }

    // Crear garantía
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'repair_id' => 'required|exists:repairs,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $garantia = Guarantee::create([
            'user_id' => $request->user_id,
            'repair_id' => $request->repair_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return response()->json(['message' => 'Garantía creada', 'data' => $garantia], 201);
    }

    // Buscar garantía por reparación
    public function searchByRepair($repairId)
    {
        $garantia = Guarantee::with('repair')
            ->where('user_id', Auth::id())
            ->where('repair_id', $repairId)
            ->first();

        if (!$garantia) {
            return response()->json(['message' => 'No se encontró garantía'], 404);
        }

        return response()->json($garantia);
    }

    // Actualizar garantía
    public function update(Request $request, $id)
    {
        $garantia = Guarantee::find($id);

        if (!$garantia) {
            return response()->json(['message' => 'Garantía no encontrada'], 404);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'repair_id' => 'required|exists:repairs,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $garantia->update([
            'user_id' => $request->user_id,
            'repair_id' => $request->repair_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return response()->json(['message' => 'Garantía actualizada', 'data' => $garantia]);
    }

    // Eliminar garantía
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
