<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        return Repair::with(['user', 'product'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'device_type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'problem_description' => 'required|string',
            'repair_notes' => 'nullable|string',
            'status' => 'required|in:pendiente,en progreso,terminado,entregado',
            'repair_cost' => 'nullable|numeric',
            'received_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        return Repair::create($data);
    }

    public function show(Repair $repair)
    {
        return $repair->load(['user', 'product']);
    }

    public function update(Request $request, Repair $repair)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'device_type' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'problem_description' => 'required|string',
            'repair_notes' => 'nullable|string',
            'status' => 'required|in:pendiente,en progreso,terminado,entregado',
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
