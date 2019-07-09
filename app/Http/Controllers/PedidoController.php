<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItensPedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function itensPedidoMesa($id)
    {
        $pedido = Pedido::where('finalizado', false)->where('mesas_id', $id)->whereDate('created_at', Carbon::today())->first();

        $itensPedidos = ItensPedido::where('pedidos_id', $pedido->id)->get();

        return response()->json([
            'pedido' => $pedido,
            'itens' => $itensPedidos,
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
