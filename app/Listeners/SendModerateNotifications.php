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
        $title = ($ads->moderate) ? $this->titleGood : $this->titleBad;
        $image = (!empty($ads->getMedia('cover')->first())) ? $ads->getMedia('cover')->first()->getUrl('thumb') : "/storage/images/defaults/cake.svg"  ;
        $link = route('profile.ads.edit', $ads->id);
        if(empty($moderate)) {
            return  [
                'title' => $title,
                'ads' => $ads->title,
                'slug' => $ads->slug,
                'img' => $image,
                'link' => $link
            ];
        };
         foreach($moderate->settings as $rr){
            $data['rules'][] = $rr->title;
        };
        $data['message'] = $moderate->message;
        $data['title'] = $title;
        $data['ads'] = $ads;
        $data['img'] = $image;
        $data['link'] = $link;

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
