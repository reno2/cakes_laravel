<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Profile;
use App\Models\User;
use App\Observers\ArticleObserver;
use App\Observers\ProfileObserver;
use App\Observers\UserObserver;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    public function getIds(){
        $ids = (new ProfileRepository)->getFavoritesIds();
        $count =  $ids ? count($ids) : 0;
        return ['ids' => $ids, 'count' => $count];
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
       \Debugbar::disable();
        Carbon::setLocale(config('app.locale'));
        Date::setlocale(config('app.locale'));
        Profile::observe(ProfileObserver::class);
        Article::observe(ArticleObserver::class);
        User::observe(UserObserver::class);

        view()->composer('ads.ad', function($view)
        {
            $view->with('favorites', $this->getIds()['ids']);
        });
        view()->composer('layouts.app', function($view)
        {
            $view->with('favoritesCount', $this->getIds()['count']);
        });
    }
}
