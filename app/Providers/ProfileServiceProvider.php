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

                $favorites = \DB::table('favorites')
                    ->where('profile_id', $profile->id)
                    ->count();

                $notReadComments = \DB::table('comments')
                    ->select('from_user_id',\DB::raw('COUNT(from_user_id) AS cnt, article_id'))
                    ->where([
                        ['user_id', '=', 1],
                        ['read_at',  '=', null],
                    ])
                    ->groupby(['from_user_id', 'article_id'])
                    ->get()
                    ->count();

                $view
                    ->with('profile', $profile)
                    ->with('commentsCount', $notReadComments)
                    ->with('notifications_count', $notifications->count())
                    ->with('favorites', $favorites)
                    ->with('notifications', $notifications);
            }
        );
    }

    public function register()
    {

    }
}
