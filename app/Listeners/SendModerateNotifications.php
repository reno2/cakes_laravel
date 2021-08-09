<?php

namespace App\Listeners;

use App\Events\AdsProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendModerateNotifications
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdsProcessed  $event
     * @return void
     */
    public function handle(AdsProcessed $event)
    {
        //
    }
}
