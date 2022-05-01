<?php

namespace App\Providers;

use App\Dto\NoticesDto;
use App\Repositories\CategoryRepository;
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

                $massagesCounts = helper_getAllNotice();
                $user =  Auth::user();
                $userId  = $user->id;
                $profile = (new ProfileRepository)->getFirstProfileByUser($user);


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
                    ->get()
                    ->count();

                $noticesDto = new NoticesDto();

                $mobileMenu = (new CategoryRepository)->forMobileMenu() ?? '';
                $view
                    ->with('mobileMenu', $mobileMenu)
                    ->with('profile', $profile)
                    ->with('favoritesCount', $favorites)
                    ->with('favorites', $favorites)
                    ->with('noticesDto', $noticesDto);
            }
        );
    }

    public function register()
    {

    }
}
