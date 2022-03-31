<?php

namespace App\Http\Controllers;

use App\Mail\EmailDespesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AutenticacaoController extends Controller
{
    public function naoAutorizado()
    {
        return response()->json([
            'erro' => 'Não autorizado.'
        ], 401);
    }

    public function registrar(Request $request)
    {
        $array = ['erro' => ''];

        $validador = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$validador->fails()) {
            $email = $request->input('email');
            $password = $request->input('password');

            $hash = Hash::make($password);

            $usuario = new User();
            $usuario->email = $email;
            $usuario->password = $hash;
            $usuario->save();

            $token = auth()->attempt([
                'email' => $email,
                'password' => $password
            ]);

            if (!$token) {
                $array['erro'] = 'Ocorreu um erro interno.';
                return $array;
            }

            $array['token'] = $token;

            $usuario = auth()->user();
            Mail::to($usuario->email)->send(new EmailDespesas($usuario));
            $array['usuario'] = $usuario;
        } else {
            $array['erro'] = $validador->errors()->first();
            return $array;
        }

        return $array;
    }

    public function login(Request $request)
    {
        $array = ['erro' => ''];
        $email = $request->input('email');
        $password = $request->input('password');
        $validador = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$validador->fails()) {
            $token = auth()->attempt([
                'email' => $email,
                'password' => $password
            ]);

            if (!$token) {
                $array['erro'] = 'Ocorreu um erro interno.';
                return $array;
            }

            $array['token'] = $token;

            $usuario = auth()->user();
            $array['usuario'] = $usuario;
        } else {
            $array['erro'] = $validador->errors()->first();
            return $array;
        }

        return $array;
    }
}
