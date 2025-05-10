<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    // Vista pública - formulario contacto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email',
            'mensaje' => 'required|string|max:1000',
            'telefono' => 'nullable|string|max:20'
        ]);

        $budget = Budget::create(array_merge($validated, ['estado' => 'pendiente']));

        return response()->json(['message' => 'Presupuesto enviado correctamente'], 201);
    }

    // Vista admin
    public function index()
    {
        return Budget::orderByDesc('created_at')->get();
    }

    public function show($id)
    {
        $budget = Budget::find($id);

        if (!$budget) {
            return response()->json(['message' => 'Presupuesto no encontrado'], 404);
        }

        return response()->json($budget);
    }
}
