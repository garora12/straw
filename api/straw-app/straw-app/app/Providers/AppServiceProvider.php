<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mailer', function ($app) { 
            $app->configure('services'); 
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer'); 
        });

        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new \Illuminate\Routing\ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });
    }

    function boot()
    {
        Schema::defaultStringLength(191); //NEW: Increase StringLength
    }
}
