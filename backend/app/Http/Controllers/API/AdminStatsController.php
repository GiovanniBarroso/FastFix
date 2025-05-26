<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminStatsController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        $pedidosHoy = Order::whereDate('fecha_pedido', $hoy)->count();
        $ventasHoy = Order::whereDate('fecha_pedido', $hoy)->sum('total');
        $presupuestosPendientes = Budget::where('estado', 'pendiente')->count();
        $usuariosTotales = User::count();

        return response()->json([
            'pedidos' => $pedidosHoy,
            'ventas' => $ventasHoy,
            'presupuestos_pendientes' => $presupuestosPendientes,
            'usuarios' => $usuariosTotales,
        ]);
    }
}
