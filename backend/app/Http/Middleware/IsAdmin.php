<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user()?->loadMissing('role');

        if (!$user || $user->role?->nombre !== 'admin') {
            return response()->json(['message' => 'Acceso denegado. Solo administradores.'], 403);
        }

        return $next($request);
    }
}
