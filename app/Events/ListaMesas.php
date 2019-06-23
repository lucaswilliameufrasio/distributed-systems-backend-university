<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ListaMesas implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $listamesas;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($teste)
    {
        $this->listamesas = $teste;
    }

    // public function broadcastWith(Mesa $listamesas)
    // {
    //     $this->listamesas = $listamesas;
    //     return $listamesas;
    // }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('mesas');
    }
}
