<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    public function register_sanctum(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'device_name' => 'required|string|max:255',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar la contraseña
        ]);

        // Crear un token de acceso personal
        $token = $user->createToken($request->device_name)->plainTextToken;

        // Devolver la respuesta
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
    public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar la contraseña
        ]);

        // Generar el token de acceso
        $token = JWTAuth::fromUser($user);

        // Devolver un objeto JSON con el token de acceso
        return response()->json(['token' => $token], 201);
    }
    // Login y generación del token JWT
    public function login(Request $request)
    {
        // Validar credenciales
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }

        // Devolver el token si la autenticación fue exitosa
        return response()->json(['token' => $token]);
    }

    // Método para obtener información del usuario autenticado
    public function me()
    {
        $user = JWTAuth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        return response()->json($user);
    }



    
}
