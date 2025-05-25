<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Devuelve todos los roles disponibles.
     */
    public function index(): JsonResponse
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
