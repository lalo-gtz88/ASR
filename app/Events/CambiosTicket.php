<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CambiosTicket
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticketOld;
    public Ticket $ticketNew;

    /**
     * Create a new event instance.
     */
    public function __construct($ticketOld, $ticketNew)
    {
        $this->ticketOld = $ticketOld;
        $this->ticketNew = $ticketNew;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
