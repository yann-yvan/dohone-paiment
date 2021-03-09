<?php


namespace Dohone\Facades;


use Illuminate\Support\Facades\Facade;

class DohonePayOut extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'payout';
    }
}