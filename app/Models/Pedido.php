<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'statusPedido',
        'valor',
        'finalizado',
        'mesas_id',
    ];

    public function itenspedidos(){
        return $this->hasMany('App\ItensPedidos');
    }
}
