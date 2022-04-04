<?php

namespace App\Listeners;

use App\Events\AdsModerate;
use App\Models\User;
use App\Notifications\ModerateNotification;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class AfterVerifiedNotifications
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
                'link' => $link,
                'moderate' => true
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
        $data['moderate'] = false;
        return $data;
    }
    /**
     * Handle the event.
     *
     * @param AdsModerate $event
     * @param $data
     * @return void
     */
    public function handle(Verified  $event)
    {

        $userTo = $event->user;
        Log::emergency($userTo);
        Notification::send($userTo, new NewUserNotification($userTo));
    }
}
