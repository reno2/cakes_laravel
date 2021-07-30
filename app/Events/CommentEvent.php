<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     * @param $data
     */
    public function __construct($data)
    {
        Log::error( json_encode($data). ','. __FILE__);
        $this->dontBroadcastToCurrentUser();
        $this->data = $data;
    }
    /**
     * Get the channels the event should broadcast on.
     *9
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.'. $this->data['room']);
    }

    public function broadcastAs()
    {
        
        return 'questions';
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->data,
        ];
    }
}
