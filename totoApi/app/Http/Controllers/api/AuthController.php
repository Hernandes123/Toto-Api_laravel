<?php

namespace App\Http\Controllers\api;

use DB;
use Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PasswordResetRequest;


class AuthController extends Controller
{
     /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:120',
            'cpf_cnpj' => 'required|max:20|unique:users',
            'email' => 'required|max:89|email|unique:users',
            'telefone' => 'required|max:15',
            'password' => 'required|min:8'
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 400);
        }

        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->password);
        $user = User::create($inputs);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
          'access_token' => $tokenResult->accessToken,
          'token_type' => 'Bearer',
          'expires_at' => Carbon::parse(
              $tokenResult->token->expires_at
          )->toDateTimeString()
      ]);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
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
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json(
            ['message' => '', 'error' => false, 'data' => [
                'user' => $user,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]],
            200
        );
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
            'error' => false, 'data' => []
        ], 200);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $data = User::join('pessoas', 'pessoas.id', '=', 'users.pessoa_id')
        ->select('pessoas.*', 'users.*')->findOrFail($request->user()->id);
        return response()->json([
            'message' => '',
            'error' => false, 'data' => $data
        ], 200);
    }

    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:120',
            'apelido' => 'max:120',
            'tipo' => 'required',
            'nif' => 'required|max:20|unique:pessoas,nif,'.$request->user()->pessoa_id,
            'email' => 'required|max:89|email|unique:users,email,' . $request->user()->id,
            'telefone' => 'required|max:15',
            'celular' => 'max:15',
            'cep' => 'required|max:9',
            'endereco' => 'required|max:100',
            'cidade_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(
                ['message' => $validator->errors()->all(), 'error' => true, 'data' => []],
                422
            );
        }

        $inputs = $request->all();
        Pessoa::updateOrCreate(['nif' => $inputs['nif']], $inputs);
        $request->user()->fill($inputs)->save();

        return response()->json(
            ['message' => 'Perfil atualizado com sucesso.', 'error' => false, 'data' => []],
            200
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user)
        return response()->json(
            ['message' => 'Email não cadastrado.', 'error' => true, 'data' => []],
            400
        );

        $token = app('auth.password.broker')->createToken($user);

        DB::table(config('auth.passwords.users.table'))->insert([
            'email' => $user->email,
            'token' => $token
        ]);

        $user->notify(
            new PasswordResetRequest($token)
        );


        return response()->json(
            ['message' => 'O link de resetar senha foi enviado no seu email.', 'error' => false, 'data' => []],
            200
        );
    }

}