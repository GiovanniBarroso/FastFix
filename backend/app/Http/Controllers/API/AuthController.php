<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\ValidationException;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
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
            'user' => $user
        ]);
    }


    public function register(Request $request)
{
    if ($request->email === 'admin@fastfix.com') {
        return response()->json(['error' => 'Este correo está reservado para administración'], 403);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // 🔔 Enviar email de verificación
    $user->sendEmailVerificationNotification();

    // 🔐 Generar token JWT
    $token = JWTAuth::fromUser($user);

    return response()->json([
        'message' => 'Cuenta creada correctamente.',
        'token' => $token,
        'user' => $user,
        'role' => $user->role_id === 1 ? 'admin' : 'user'
    ], 201);
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
            'email' => $user->email,
            'is_admin' => $user->email === 'admin@fastfix.com'
        ]);
    }
}
