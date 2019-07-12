<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Mesa;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class FinanceiroController extends Controller
{
    public function registrarGarcom(Request $request)
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
            'nivelAcesso_id' => 3,
        ]);

        return response()->json([
            'message' => 'Garçom cadastrado com sucesso.',
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function registrarAgenteProducao(Request $request)
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
            'nivelAcesso_id' => 2,
        ]);

        DB::table('usuarioAgenteProducao')->insert([
            'users_id' => $user->id,
            'estacaoProducao_id' => $request->estacao,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Agente de Produção cadastrado com sucesso.',
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function cadastraProduto(Request $request)
    {
        $produto = Produto::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'ingredientes' => $request->ingredientes,
            'tipoProduto_id' => $request->tipoproduto,
        ]);

        return response()->json(
            $produto, 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function listarAgentesProducao()
    {
        $agentes = User::where('nivelAcesso_id', 2)->get();

        return response()->json([
            'agentes' => $agentes,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function listarGarcons()
    {
        $agentes = User::where('nivelAcesso_id', 3)->get();

        return response()->json([
            'garcons' => $agentes,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function cadastrarMesa(Request $request){

        Mesa::create([
            'id' => $request->id,
            'status' => false,
        ]);
        return response()->json([
            'data' => 'Mesa cadastrada com sucesso',
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
