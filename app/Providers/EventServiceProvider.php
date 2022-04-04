<?php

namespace App\Providers;


use App\Events\AdsEvent;
use App\Listeners\ModerateNotification;
use App\Events\AdsModerate;
use App\Listeners\SendModerateNotifications;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Маппим класс выбрасываемого события со слушателями
     *
     * @var array
     */
    protected $listen = [
        AdsModerate::class => [
            SendModerateNotifications::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AdsEvent::class => [
            ModerateNotification::class
        ],
        'Illuminate\Auth\Events\Verified' => [
            'App\Listeners\AfterVerifiedNotifications',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\VKontakte\\VKontakteExtendSocialite@handle',
            'SocialiteProviders\\Instagram\\InstagramExtendSocialite@handle',
            'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
