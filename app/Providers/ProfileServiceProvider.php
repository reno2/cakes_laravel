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
                $user =  Auth::user();
                $userId  = $user->id;
                $profile = (new ProfileRepository)->getFirstProfileByUser($user);
                $moderateNotifications =  (new App\Repositories\UserRepository())->getNotReadModerateNotice();
                $notifications =  Auth::user()->unreadNotifications;

                $commentsRepository = new App\Repositories\CommentsRepository();

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
                    ->with('notReadQuestions', $commentsRepository->notReadQuestions(Auth::id()))
                    ->with('notReadAnswers', $commentsRepository->notReadAnswers(Auth::id()))
                    ->with('profile', $profile)
                    //->with('commentsCount', $notReadComments)
                    ->with('notifications_count', $notifications)
                    ->with('commentsCount', $notReadComments)
                    ->with('notifications_count', $moderateNotifications)
                    ->with('favorites', $favorites)
                    ->with('notifications', $moderateNotifications);
            }
        );
    }

    public function register()
    {

    }
}
