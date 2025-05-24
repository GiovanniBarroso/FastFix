<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Notification;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if ($request->email === 'admin@fastfix.com') {
            return response()->json(['error' => 'Este correo está reservado para administración'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'telefono' => ['required', 'regex:/^\d{9}$/'],
            'apellidos' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{2,}$/'],
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'telefono.regex' => 'El teléfono debe tener exactamente 9 dígitos numéricos.',
            'apellidos.regex' => 'Los apellidos deben contener solo letras y al menos 2 caracteres.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        // ✅ Notificación al registrar usuario
        Notification::create([
            'title' => 'Nuevo registro',
            'message' => "Se ha registrado un nuevo usuario: \"{$user->name}\".",
            'type' => 'registro',
            'read' => false,
        ]);

        return response()->json([
            'message' => 'Cuenta creada correctamente. Por favor, verifica tu correo antes de iniciar sesión.'
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        $user = auth('api')->user();

        if (!$user->hasVerifiedEmail()) {
            auth('api')->logout();
            return response()->json(['error' => 'Debes verificar tu correo electrónico antes de iniciar sesión.'], 403);
        }

        return response()->json([
            'token' => $token,
            'user' => $user,
            'role' => $user->role_id === 1 ? 'admin' : 'user'
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function me()
    {
        $user = auth('api')->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'apellidos' => $user->apellidos,
            'telefono' => $user->telefono,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'is_admin' => $user->email === 'admin@fastfix.com'
        ]);
    }
}
