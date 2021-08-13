<?php

namespace App\Events;

use App\Models\Article;
use App\Models\Moderate;
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
    public $mess;

    /**
     * Create a new event instance.
     *
     * @param Article $ads
     * @param  $mess
     */
    public function __construct(Article $ads, $mess = null)
    {
        $this->mess = $mess;
        $this->ads = $ads;
    }


}
