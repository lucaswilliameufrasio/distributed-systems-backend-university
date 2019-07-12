<?php

namespace App\Http\Controllers;

use App\Models\ItensPedido;
use App\Models\Pedido;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function itensPedidoMesa($id)
    {
        $pedido = Pedido::where('finalizado', false)->where('mesas_id', $id)->whereDate('created_at', Carbon::today())->first();

        if (!$pedido) {
            return response()->json([
                'data' => 'Não há pedidos para nesta mesa.',
            ], 200,
                ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        }

        $itensPedidos = DB::table('itensPedidos')
            ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
            ->where('pedidos.mesas_id', $id)
            ->where('pedidos.finalizado', false)
            ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
            ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
            ->get();

        $pedido = Pedido::where('pedidos.mesas_id', $id)->where('pedidos.finalizado', false)->get();
        $produtos = Produto::get();
        return response()->json([
            'pedido' => $pedido,
            'itens' => $itensPedidos,
            'produtos' => $produtos,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function adicionarItemPedido(Request $request, $id)
    {
        $itemPedido = ItensPedido::create([
            'pedidos_id' => $request->pedidoid,
            'produtos_id' => $id,
            'estacaoProducao_id' => $request->estacaoid,
            'statusItemPedido' => false,
        ]);

        $valorproduto = Produto::where('id', $id)->firstOrFail();
        $valoratual = Pedido::where('id', $itemPedido->pedidos_id)->firstOrFail();
        $valoratual = $valoratual->valor + $valorproduto->valor;

        Pedido::where('id', $itemPedido->pedidos_id)->update([
            'valor' => $valoratual,
        ]);

        return response()->json([
            'data' => 'Item adicionado com sucesso',
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
