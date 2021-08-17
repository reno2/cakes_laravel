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

    private $titleBad = 'Объявление не прошло модерацию';
    private $titleGood = 'Объявление прошло модерацию';
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
        $data['img'] = (!empty($ads->getMedia('cover')->first())) ? $ads->getMedia('cover')->first()->getUrl('thumb') : "/storage/images/defaults/cake.svg"  ;
        $data['link'] = route('profile.ads.edit', $ads->id);

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
