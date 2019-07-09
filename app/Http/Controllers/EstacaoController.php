<?php

namespace App\Http\Controllers;

use App\Models\ItensPedido;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class EstacaoController extends Controller
{
    public function listarItensEstacao($id)
    {

        $itensPedido = DB::table('itensPedidos')
            ->where('estacaoProducao_id', $id)
            ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
            ->get();

        return response()->json([
            'itens' => $itensPedido,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function confirmarPreparo($id)
    {
        ItensPedido::where('id', $id)->update([
            'estacaoProducao_id' => 3,
        ]);

        $this->verificaPedidoPronto($id);

        return response()->json([
            'data' => 'Item pronto',
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function verificaPedidoPronto($id)
    {
        $itempedido = ItensPedido::where('id', $id)->firstOrFail();
        $pedido = Pedido::where('id', $itempedido->pedidos_id)->firstOrFail();
        $itens = ItensPedido::where('pedidos_id', $pedido->id)->get();
        // dd($itens);

        foreach ($itens as $item) {
            if ($item->statusItemPedido) {
                $status = true;
            } else {
                $status = false;
            }
        }

        if($status){
            Pedido::where('id', $itempedido->pedidos_id)->update([
                'statusPedido' => 'Pronto',
            ]);
        }
    }
}
