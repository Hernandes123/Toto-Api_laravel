<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class LoginController extends Controller
{
    public function teste(){
        return User::all();
    }

  
        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' =>    'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json(
                    ['message' => $validator->errors()->all(), 'error' => true, 'data' => []],
                    400
                );
            }
    
            $credentials = request(['email', 'password']);
            if(!auth()->attempt($credentials)){
                $mensagem = '';
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    $mensagem = 'E-mail não cadastrado.';
                } else {
                    $mensagem = 'Senha Incorreta.';
                }
                return response()->json(
                    ['message' => $mensagem, 'error' => true, 'data' => []],
                    400
                );
            }
            
         
        }


        //Logout / Sair da sessão
        public function logout(Request $request)
        {
        $request->user();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 201);
        }
}
