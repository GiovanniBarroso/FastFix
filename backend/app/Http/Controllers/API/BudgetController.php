<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Notification;
use App\Mail\BudgetReplyMail;
use Illuminate\Support\Facades\Mail;

class BudgetController extends Controller
{
    // Vista pública - formulario de contacto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mensaje' => 'required|string|max:1000',
            'estado' => 'in:pendiente,respondido,rechazado'
        ]);

        $user = auth()->user();

        $budget = Budget::create([
            'user_id' => $user->id,
            'mensaje' => $validated['mensaje'],
            'estado' => $validated['estado'] ?? 'pendiente'
        ]);

        // ✅ Crear notificación para admin
        Notification::create([
            'title' => 'Nueva solicitud de presupuesto',
            'message' => "El usuario \"{$user->nombre}\" ha enviado una solicitud de presupuesto.",
            'type' => 'presupuesto',
            'read' => false,
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

    // ✅ Responder al cliente por email y actualizar campos
    public function reply(Request $request, $id)
    {
        $budget = Budget::with('user')->find($id);

        if (!$budget || !$budget->user) {
            return response()->json(['message' => 'Presupuesto o usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'mensaje' => 'required|string',
            'presupuesto_estimado' => 'nullable|numeric'
        ]);

        // Enviar correo al cliente
        Mail::to($budget->user->email)->send(new BudgetReplyMail(
            $budget->user->nombre,
            $validated['mensaje']
        ));

        // Guardar respuesta en la base de datos
        $budget->update([
            'respuesta_admin' => $validated['mensaje'],
            'presupuesto_estimado' => $validated['presupuesto_estimado'] ?? null,
            'estado' => 'respondido',
            'fecha_respuesta' => now(),
        ]);

        return response()->json(['message' => 'Respuesta enviada y guardada correctamente.']);
    }

    // ✅ Actualizar estado
    public function update(Request $request, $id)
    {
        $budget = Budget::find($id);

        if (!$budget) {
            return response()->json(['message' => 'Presupuesto no encontrado'], 404);
        }

        $validated = $request->validate([
            'estado' => 'required|in:pendiente,respondido,rechazado',
            'presupuesto_estimado' => 'nullable|numeric',
            'respuesta_admin' => 'nullable|string',
        ]);

        $budget->update($validated);

        return response()->json(['message' => 'Presupuesto actualizado correctamente.']);
    }

}
