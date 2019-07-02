<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'ativo' => 1,
            'nivelAcesso_id' => $request->nivelacesso,
        ]);

        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        try {
            //Se a tentativa de login for falha
            if (!$token = JWTAuth::attempt($credentials)) {

                Log::info('Usuario não obteve êxito no login.');

                return response()->json([
                    'success' => false,
                    'status' => 'invalid_credentials'], 401);
            } else {
                //Se a tentiva de login for bem sucedida
                return $this->respondWithToken($token);
            }
        } catch (JWTException $e) {

            Log::error($e);

            return response()->json([
                'success' => false,
                'status' => 'could_not_create_token'], 500);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'status' => 'successful_logout']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
        ]);
    }
    public function criaLogAutenticacao($credentials)
    {
        $mensagem = 'usuario '+$credentials->email+'logado com sucesso.';

        DB::table('logAutenticacao')->insert([
            'mensagem' => $mensagem,
            '',
        ]);
    }
    public function open()
    {
        return response()->json([
            'success' => true,
            'data' => 'Esses dados são livres e podem ser acessados sem a necessidade de autenticação.',
        ], 200);
    }

    public function closed()
    {
        return response()->json([
            'success' => true,
            'data' => 'Apenas usuários autorizados podem ver isso.',
        ], 200);
    }

    public function verificaToken()
    {
        return response()->json([
            'success' => true,
            'data' => 'Apenas usuários autorizados podem ver isso.',
        ], 200);
    }
}
