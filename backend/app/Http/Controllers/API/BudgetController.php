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
            'mensaje' => 'required|string|max:1000',
        ]);

        $budget = Budget::create([
            'user_id' => auth()->id(), // Usuario autenticado
            'mensaje' => $validated['mensaje'],
            'estado' => 'pendiente'
        ]);

        return response()->json(['message' => 'Presupuesto enviado correctamente'], 201);
    }

    // Vista admin - listar todos con usuario incluido
    public function index()
    {
        return Budget::with('user')->orderByDesc('created_at')->get();
    }

    // Vista admin - ver uno
    public function show($id)
    {
        $budget = Budget::with('user')->find($id);

        if (!$budget) {
            return response()->json(['message' => 'Presupuesto no encontrado'], 404);
        }

        return response()->json($budget);
    }

    // ✅ Responder al cliente por email
    public function reply(Request $request, $id)
    {
        $budget = Budget::with('user')->find($id);

        if (!$budget || !$budget->user) {
            return response()->json(['message' => 'Presupuesto o usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'mensaje' => 'required|string'
        ]);

        // Enviar correo al usuario
        Mail::to($budget->user->email)->send(new BudgetReplyMail(
            $budget->user->name,
            $validated['mensaje']
        ));

        return response()->json(['message' => 'Mensaje enviado correctamente.']);
    }
}
