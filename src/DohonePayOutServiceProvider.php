<?php


namespace Dohone\PayOut;
use Dohone\PayOut\Dohone\PayOut\DohonePayOut;
use Illuminate\Support\ServiceProvider;

class DohonePayOutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('payout', function($app) {
            return new DohonePayOut();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/dohone.php', 'dohone');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('dohone.php'),
            ], 'config');

        }
    }
}