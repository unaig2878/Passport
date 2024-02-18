<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $loginType = (strpos($request->input('login'), '@') !== false) ? 'email' : 'name';

        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
       
            $token = $request->user()->createToken('SaccessToken')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {

            throw validationException::withMessages([
                'success' => false,
                'message' => 'Credenciales incorrectas',
                'data' => $request,
                'status' => 401
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            return $this->successResponse('Cerrar sesión realizado con éxito');
        } else {
            return $this->errorResponse('No estás autorizado para cerrar sesión', $user);
        }
    }

    public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);


        return response()->json(['message' => 'Usuario registrado con éxito'], 201);
    }
}