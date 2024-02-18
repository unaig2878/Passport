<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mostrarPerfil(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            return $this->successResponse('Perfil encontrado', $user);
        }

        return $this->errorResponse('Perfil no encontrado', null);
    }

    //ruta solo para la practica
    public function a()
    {
        echo 'a';
    }

}
