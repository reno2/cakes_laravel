<?php

namespace App\Listeners;

use App\Events\AdsModerate;
use App\Models\User;
use App\Notifications\ModerateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
     * @param AdsModerate $event
     * @param $data
     * @return void
     */
    public function handle(AdsModerate $event)
    {

        $userTo = User::find($event->ads->user_id);
        Notification::send($userTo, new ModerateNotification($event->data));
    }
}
