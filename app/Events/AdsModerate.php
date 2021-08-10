<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdsModerate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ads;
    public $data;
    /**
     * Create a new event instance.
     *
     * @param Article $ads
     * @param $data
     */
    public function __construct(Article $ads, $data)
    {
        $this->data = $data;
        $this->ads = $ads;
    }


}
