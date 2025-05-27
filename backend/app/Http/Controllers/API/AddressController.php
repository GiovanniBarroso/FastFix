<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{
    // ✅ Ver todas las direcciones del usuario
    public function index()
    {
        return Address::where('user_id', Auth::id())->get();
    }

    // ✅ Crear una nueva dirección
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:100',              // Añadido 👈
        'calle' => 'required|string|max:255',
        'numero' => 'required|string|max:20',
        'ciudad' => 'required|string|max:100',
        'provincia' => 'required|string|max:100',
        'codigo_postal' => 'required|string|max:10',
        'pais' => 'required|string|max:100',
        'principal' => 'nullable|boolean'
    ]);

    $address = Address::create([
        ...$validated,
        'user_id' => Auth::id()
    ]);

    return response()->json(['message' => 'Dirección añadida', 'data' => $address], 201);
}

    // ✅ Actualizar dirección
    public function update(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$address) {
            return response()->json(['message' => 'Dirección no encontrada'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',              // Añadido también
            'calle' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'ciudad' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'pais' => 'required|string|max:100'
        ]);
        

        $address->update($validated);

        return response()->json(['message' => 'Dirección actualizada', 'data' => $address]);
    }

    // ✅ Eliminar dirección
    public function destroy($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$address) {
            return response()->json(['message' => 'Dirección no encontrada'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Dirección eliminada']);
    }
}
