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

                $comments =  \DB::table('comments')

                    ->where(function($query) use ($userId) {
                        $query->where('from_user_id', $userId)
                            ->orWhere('user_id', $userId);
                    })
                    ->where(function($query) {
                        $query->where('recipient_read_at', null)
                            ->orWhere('user_id', null);
                    })->count();

                $favorites = \DB::table('favorites')
                    ->where('profile_id', $profile->id)
                    ->count();



                $notReadComments = \DB::table('comments')
                    ->select('id')
                    //->select('from_user_id', \DB::raw('COUNT(from_user_id) AS cnt, article_id'))
//                    ->where([
//                        ['user_id', '=', $userId],
//                        ['recipient_read_at',  '=', null],
//                    ])
                   // ->where('recipient_read_at', null)
                    //->where('user_id', Auth::id())


                    ->where('user_id', $userId)
                    ->where(function($query) {
                        $query->where('recipient_read_at', '=', null)
                            ->orWhere('sender_read_at', '=', null);
                    })


                    //->groupby(['from_user_id', 'article_id'])
                    ->get()
                    ->count();
               // dd($notReadComments);
                $view
                    ->with('profile', $profile)
                    ->with('commentsCount', $notReadComments)
                    ->with('notifications_count', $notifications)
                    ->with('favorites', $favorites)
                    ->with('notifications', $notifications);
            }
        );
    }

    public function register()
    {

    }
}
