<?php

namespace App\Providers;

use App\Dto\NoticesDto;
use App\Models\Article;
use App\Models\Category;
use App\Models\Profile;
use App\Models\User;
use App\Models\Comment;
use App\Observers\ArticleObserver;
use App\Observers\CategoryObserver;
use App\Observers\CommentObserver;
use App\Observers\ProfileObserver;
use App\Observers\UserObserver;
use App\Repositories\CategoryRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public $ids = null;
    public function getIds(){
        if(!$this->ids)
            $ids = (new ProfileRepository)->getFavoritesIds();
        else $ids = $this->ids;
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
        Comment::observe(CommentObserver::class);
        Category::observe(CategoryObserver::class);

        view()->composer('ads.ad_detail', function($view)
        {
            $view->with('favorites', $this->getIds()['ids']);
        });
        view()->composer('ads.ad', function($view)
        {
            $view->with('favorites', $this->getIds()['ids']);
        });
        view()->composer('ads.ad_front', function($view)
        {
            $view->with('favorites', $this->getIds()['ids']);
        });
        view()->composer('layouts.app', function($view)
        {



            $noticesDto = new NoticesDto();
            $mobileMenu = (new CategoryRepository)->forMobileMenu() ?? '';
            $view
                ->with('mobileMenu', $mobileMenu)
                ->with('favoritesCount', $this->getIds()['count'] ?? 0)

                ->with('noticesDto', $noticesDto);
        });
    }
}
