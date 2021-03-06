<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProfileRepository;

use App;
use Blade;

class ProfileServiceProvider extends ServiceProvider
{
    public function boot()
    {

        view()->composer(
            'layouts.profile',
            function ($view) {
                $userId  = Auth::user()->id;
                $profile = (new ProfileRepository)->getEdit($userId);
                $notifications =  Auth::user()->unreadNotifications;
                //dd($userId);
                $view
                    ->with('profile', $profile)
                    ->with('notifications_count', $notifications->count())
                    ->with('notifications', $notifications);
            }
        );
    }

    public function register()
    {

    }
}
