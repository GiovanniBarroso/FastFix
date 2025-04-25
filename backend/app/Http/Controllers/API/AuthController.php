<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        logger('TOKEN GENERADO: ' . $token);

        return response()->json([
            'token' => $token,
            'user' => auth('api')->user()
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

        $token = auth('api')->login($user);

        return response()->json([
            'token' => $token,
            'user' => $user
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
            'email' => $user->email,
            // Simulación del rol admin (puedes cambiar esto si usas una columna real)
            'is_admin' => $user->email === 'admin@fastfix.com'
        ]);
    }

}
