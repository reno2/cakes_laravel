<?php

namespace App\Listeners;

use App\Events\AdsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModerateNotification implements ShouldQueue
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
     * @param AdsEvent $event
     * @return void
     */
    public function handle(AdsEvent $event)
    {
        //
    }
}
