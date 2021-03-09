<?php


namespace Dohone;
use Dohone\Facades\DohonePayOut;
use Dohone\PayIn\DohonePayIn;
use Illuminate\Support\ServiceProvider;

class DohonePayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('payin', function($app) {
            return new DohonePayIn();
        });

        $this->app->bind('payout', function($app) {
            return new DohonePayOut();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'dohone');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dohone');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('dohone.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/dohone'),
            ], 'views');
        }
    }
}