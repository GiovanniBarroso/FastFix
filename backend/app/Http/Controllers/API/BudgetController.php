<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Mail\BudgetReplyMail;
use Illuminate\Support\Facades\Mail;

class BudgetController extends Controller
{
    // Vista pública - formulario de contacto
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

    // Vista admin - listar todos
    public function index()
    {
        return Budget::orderByDesc('created_at')->get();
    }

    // Vista admin - ver uno
    public function show($id)
    {
        $budget = Budget::find($id);

        if (!$budget) {
            return response()->json(['message' => 'Presupuesto no encontrado'], 404);
        }

        return response()->json($budget);
    }

    // ✅ Nuevo método: responder por email
    public function reply(Request $request, $id)
    {
        $budget = Budget::find($id);

        if (!$budget) {
            return response()->json(['message' => 'Presupuesto no encontrado'], 404);
        }

        $validated = $request->validate([
            'mensaje' => 'required|string'
        ]);

        // Enviar correo al cliente
        Mail::to($budget->email)->send(new BudgetReplyMail(
            $budget->nombre,
            $validated['mensaje']
        ));


        return response()->json(['message' => 'Mensaje enviado correctamente.']);
    }
}
