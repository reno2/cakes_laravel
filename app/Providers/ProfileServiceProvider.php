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
                $userId = Auth::user()->id;
                $profile = (new ProfileRepository)->getEdit($userId);
                //dd($userId);
                $view->with('profile', $profile);
            }
        );
    }

    public function register()
    {

    }
}
