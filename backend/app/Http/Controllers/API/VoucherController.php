<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VoucherController extends Controller
{
    // ✅ Listar todos los cupones (admin)
    public function index()
    {
        return Voucher::orderByDesc('created_at')->get();
    }

    // ✅ Crear un nuevo cupón
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:vouchers',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'required|boolean'
        ]);

        $voucher = Voucher::create($validated);

        return response()->json(['message' => 'Cupón creado', 'data' => $voucher], 201);
    }

    // ✅ Editar cupón
    public function update(Request $request, $id)
    {
        $voucher = Voucher::find($id);
        if (!$voucher) {
            return response()->json(['message' => 'Cupón no encontrado'], 404);
        }

        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:vouchers,codigo,' . $id,
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'activo' => 'required|boolean'
        ]);

        $voucher->update($validated);

        return response()->json(['message' => 'Cupón actualizado', 'data' => $voucher]);
    }

    // ✅ Eliminar cupón
    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        if (!$voucher) {
            return response()->json(['message' => 'Cupón no encontrado'], 404);
        }

        $voucher->delete();

        return response()->json(['message' => 'Cupón eliminado']);
    }

    // ✅ Validar un código de cupón desde frontend
    public function validateCode(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ]);

        $voucher = Voucher::where('codigo', $request->codigo)
            ->where('activo', true)
            ->whereDate('fecha_inicio', '<=', Carbon::now())
            ->whereDate('fecha_fin', '>=', Carbon::now())
            ->first();

        if (!$voucher) {
            return response()->json(['valid' => false, 'message' => 'Cupón no válido o expirado'], 404);
        }

        return response()->json(['valid' => true, 'voucher' => $voucher]);
    }
}
