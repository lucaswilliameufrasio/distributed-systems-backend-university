<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    public function itempedido()
    {
        return $this->hasOne('App\Pedido');
    }
}
