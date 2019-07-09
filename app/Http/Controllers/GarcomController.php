<?php

namespace App\Http\Controllers;

use App\Events\ListaMesas;
use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GarcomController extends Controller
{
    public function mesas()
    {
        $params = Mesa::orderBy('id', 'asc')->get();

        return response()->json(
            $params, 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function abrirMesa(Request $request, $id)
    {
        //Atualiza o status da mesa para true, ativa
        Mesa::where('id', $id)->update([
            'status' => $request->status,
        ]);

        //Cria um pedido para a mesa correspondente
        $pedido = Pedido::create([
            'statusPedido' => 'Em produção',
            'valor' => 0,
            'finalizado' => false,
            'mesas_id' => $id,
        ]);

        DB::table('logPedidos')->insert([
            'mensagem' => 'Pedido ' . $pedido->id . ' criado.',
            'users_id' => Auth::user()->id,
            'mesas_id' => $id,
            'pedidos_id' => $pedido->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $params = Mesa::orderBy('id', 'asc')->get();

        //Dispara um evento após atualizar o status da mesa
        event(new ListaMesas($params));

        return response()->json(
            $params, 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function listaProdutos()
    {

        $produtos = Produto::get();

        return response()->json([
            'produtos' => $produtos,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function fecharPedido($id)
    {
        Pedido::where('id', $id)->update([
            'statusPedido' => 'Finalizado',
            'finalizado' => true,
        ]);
        $pedido = Pedido::where('id', $id)->firstOrFail();

        // dd($pedido);
        $mensagem = "Pedido " . $pedido->id . " foi fechado com sucesso!";

        DB::table('logPedidos')->insert([
            'mensagem' => $mensagem,
            'users_id' => Auth::user()->id,
            'mesas_id' => $pedido->mesas_id,
            'pedidos_id' => $pedido->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'produtos' => $mensagem,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
