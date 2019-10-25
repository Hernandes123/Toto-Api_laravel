<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Hash;
use Validator;

class ApiLoginController extends Controller
{
    public function login(Request $request){
        $usuario = Usuario::where('email', $request->email)->first();

        if($usuario && hash::check($request->password, $usuario->password)){
            return response()->json($usuario);
        }
        return response()->json(['messagem' => 'Erro']);
        
    }

    public function entrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' =>    'required'
        ]);


    
            $data = [
            'email' => $request->email,
            'password' =>   $request->password
            ];

            return Usuario::select($data);
        
    }

    public function show($id)
    {
        $usuario = Usuario::with('email')->find($id);

        if(!$usuario) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($usuario);
    }
}