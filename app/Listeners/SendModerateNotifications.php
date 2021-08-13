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

    private $titleBad = 'Ваше объявление не прошло модерацию';
    private $titleGood = 'Ваше объявление прошло модерацию';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    private function dataHandler($moderate, $ads){

        if(empty($moderate)) {
            return  [
                'title' => $this->titleGood,
                'ads' => $ads->title,
                'slug' => $ads->slug
            ];
        };
         foreach($moderate->settings as $rr){
            $data['rules'][] = $rr->title;
        };
        $data['message'] = $moderate->message;
        $data['title'] = $this->titleBad;
        $data['ads'] = $ads;

        return $data;
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
        $data = $this->dataHandler($event->mess, $event->ads);
        Notification::send($userTo, new ModerateNotification($data));
    }
}
