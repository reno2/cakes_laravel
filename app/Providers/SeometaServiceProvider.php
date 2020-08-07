<?php

namespace App\Providers;

use App\Seo\Seometa;
use App\Seo\SeometaFacade;
use Illuminate\Support\ServiceProvider;


class SeometaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('seometa', function($app){
            return new Seometa();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //$rr = SeometaFacade::sayHello();
        //$h= '';
    }
}
