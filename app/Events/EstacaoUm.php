<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EstacaoUm implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $itens;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($estacaoum)
    {
        $this->itens = $estacaoum;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('estacaoum');
    }
}
