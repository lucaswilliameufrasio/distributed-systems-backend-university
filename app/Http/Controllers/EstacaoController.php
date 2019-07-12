<?php

namespace App\Http\Controllers;

use App\Events\EstacaoUm;
use App\Events\EstacaoDois;
use App\Events\EstacaoTres;
use App\Models\ItensPedido;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class EstacaoController extends Controller
{
    public function listarItensEstacao($id)
    {
        $itensPedido = DB::table('itensPedidos')
            ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
            ->where('estacaoProducao_id', $id)
            ->where('pedidos.statusPedido', "Em produção")
            ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
            ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
            ->get();

        return response()->json([
            'itens' => $itensPedido,
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function confirmarPreparo($id)
    {
        $estacao = ItensPedido::where('id', $id)->first();
        ItensPedido::where('id', $id)->update([
            'estacaoProducao_id' => 3,
        ]);

        if (isset($estacao) && $estacao->estacaoProducao_id == 1) {
            $paramsum = DB::table('itensPedidos')
                ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
                ->where('estacaoProducao_id', 1)
                ->where('pedidos.statusPedido', "Em produção")
                ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
                ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
                ->get();

            //Dispara um evento após atualizar o status da mesa
            event(new EstacaoUm($paramsum));
        } else {
            $paramsdois = DB::table('itensPedidos')
                ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
                ->where('estacaoProducao_id', 2)
                ->where('pedidos.statusPedido', "Em produção")
                ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
                ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
                ->get();

            //Dispara um evento após atualizar o status da mesa
            event(new EstacaoDois($paramsdois));
        }
        $paramstres = DB::table('itensPedidos')
            ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
            ->where('estacaoProducao_id', 3)
            ->where('pedidos.statusPedido', "Em produção")
            ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
            ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
            ->get();

        //Dispara um evento após atualizar o status da mesa
        event(new EstacaoTres($paramstres));

        return response()->json([
            'data' => 'Item pronto',
        ], 200,
            ['Content-type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function finalizarProcesso($id)
    {
        $estacao = ItensPedido::where('id', $id)->first();

        ItensPedido::where('id', $id)->where('estacaoProducao_id', 3)->update([
            'statusItemPedido' => true,
        ]);

        $this->verificaPedidoPronto($id);

        if (isset($estacao) && $estacao->estacaoProducao_id == 1) {
            $paramsum = DB::table('itensPedidos')
                ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
                ->where('estacaoProducao_id', 1)
                ->where('pedidos.statusPedido', "Em produção")
                ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
                ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
                ->get();

            //Dispara um evento após atualizar o status da mesa
            event(new EstacaoUm($paramsum));
        } else {
            $paramsdois = DB::table('itensPedidos')
                ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
                ->where('estacaoProducao_id', 2)
                ->where('pedidos.statusPedido', "Em produção")
                ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
                ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
                ->get();

            //Dispara um evento após atualizar o status da mesa
            event(new EstacaoDois($paramsdois));
        }
        $paramstres = DB::table('itensPedidos')
            ->select('itensPedidos.*', 'pedidos.*', 'produtos.*', 'itensPedidos.id as itensid')
            ->where('estacaoProducao_id', 3)
            ->where('pedidos.statusPedido', "Em produção")
            ->join('pedidos', 'pedidos.id', '=', 'itensPedidos.pedidos_id')
            ->join('produtos', 'produtos.id', '=', 'itensPedidos.produtos_id')
            ->get();

        //Dispara um evento após atualizar o status da mesa
        event(new EstacaoTres($paramstres));

        return response()->json([
            'data' => 'Processo finalizado',
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
            }
            if(!$item->statusItemPedido) {
                $status = false;
            }
        }

        if ($status) {
            Pedido::where('id', $itempedido->pedidos_id)->update([
                'statusPedido' => 'Pronto',
            ]);
        }
    }
}
