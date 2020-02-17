<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\ExpenceTransaction as Trans;

class ExpenceTransaction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $expence_tran;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Trans $expence_tran)
    {
        $this->expence_tran = $expence_tran;
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
