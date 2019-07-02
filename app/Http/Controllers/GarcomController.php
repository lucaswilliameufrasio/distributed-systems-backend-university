<?php

namespace App\Http\Controllers;

use App\Events\ListaMesas;
use App\Models\Mesa;
use Illuminate\Http\Request;

class GarcomController extends Controller
{
    public function mesas()
    {
        $params = Mesa::orderBy('id', 'asc')->get();

        return response()->json(
            $params, 200);
    }

    public function atualizaStatusMesa(Request $request, $id)
    {
        //Atualiza o status da mesa para true, ativa
        Mesa::where('id', $id)->update([
            'status' => $request['status'],
        ]);

        //Cria um pedido para a mesa correspondente
        Pedido::create([
            'statusPedido' => 'Em produção',
            'valor' => 0,
            'finalizado' => false,
            'mesas_id' => $id,
        ]);

        $params = Mesa::orderBy('id', 'asc')->get();

        //Dispara um evento após atualizar o status da mesa
        event(new ListaMesas($params));

        return response()->json(
            $params, 200);
    }
}
