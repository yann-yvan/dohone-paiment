<?php


namespace Dohone\Facades;


use Illuminate\Support\Facades\Facade;

class DohonePayIn extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'payin';
    }
}