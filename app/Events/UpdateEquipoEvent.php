<?php

namespace App\Events;

use App\Models\Equipo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateEquipoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Equipo $equipoOld;
    public Equipo $equipoNew;
    public $ipasigned;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($equipoOld, $equipoNew, $ipasigned = null)
    {
        $this->equipoOld = $equipoOld;
        $this->equipoNew = $equipoNew;

        if($ipasigned != null)
            $this->ipasigned = $ipasigned;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
