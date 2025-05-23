<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use App\Models\User;

class UserController extends Controller
{
    // ✅ Actualizar perfil del usuario autenticado
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'apellidos' => 'sometimes|nullable|string|max:100',
            'telefono' => 'sometimes|nullable|string|max:20',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json(['message' => 'Perfil actualizado', 'user' => $user]);
    }

    // ✅ Admin: ver todos los usuarios
    public function index()
    {
        return User::with('role')->orderBy('created_at', 'desc')->get();
    }

    // ✅ Admin: ver un usuario específico
    public function show($id)
    {
        $user = User::with(['role', 'addresses', 'orders'])->find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }

    // ✅ Admin: eliminar usuario
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado']);
    }

    // ✅ Admin: crear usuario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    // ✅ Admin: actualizar usuario por ID
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }
    public function updateProfileInformation(Request $request, UpdatesUserProfileInformation $updater)
    {
        $user = auth('api')->user();

        $updater->update($user, $request->all());

        return response()->json([
            'message' => 'Perfil actualizado correctamente.',
            'user' => $user,
        ]);
    }

    public function confirmPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = auth('api')->user();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'La contraseña no es correcta.'
            ], 403);
        }

        return response()->json([
            'message' => 'Contraseña confirmada correctamente.'
        ]);
    }


}
