<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id === 1) {
            return Repair::with('user')->get();
        }

        return Repair::with('user')
            ->where('user_id', $user->id)
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_type' => 'required|in:Móvil,Ordenador,Tablet,Consola',
            'nombre' => 'required|string|max:255',
            'problem_description' => 'required|string',
            'repair_notes' => 'nullable|string',
            'status' => 'required|in:pendiente,en progreso,terminado,entregado',
            'garantia' => 'required|in:sin,3m,6m',
            'repair_cost' => 'nullable|numeric',
            'received_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        return Repair::create($data);
    }

    public function show(Repair $repair)
    {
        return $repair->load('user');
    }

    public function update(Request $request, Repair $repair)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_type' => 'required|in:Móvil,Ordenador,Tablet,Consola',
            'nombre' => 'required|string|max:255',
            'problem_description' => 'required|string',
            'repair_notes' => 'nullable|string',
            'status' => 'required|in:pendiente,en progreso,terminado,entregado',
            'garantia' => 'required|in:sin,3m,6m',
            'repair_cost' => 'nullable|numeric',
            'received_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        $repair->update($data);

        return $repair;
    }

    public function destroy(Repair $repair)
    {
        $repair->delete();
        return response()->json(['message' => 'Reparación eliminada']);
    }
}
