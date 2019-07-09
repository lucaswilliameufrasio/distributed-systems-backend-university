<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItensPedido extends Model
{
    protected $table = 'itensPedidos';

    protected $fillable = [
        'pedidos_id',
        'produtos_id',
        'estacaoProducao_id',
        'statusItemPedido',
    ];

}
