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
    }

    public function boot()
    {
        //
    }
}