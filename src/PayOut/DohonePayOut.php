<?php


namespace Dohone\PayOut;


use Dohone\PayOut\Transfer\CardTransfer;
use Dohone\PayOut\Transfer\MobileTransfer;

class DohonePayOut
{

    public static function card()
    {
        return new CardTransfer();
    }

    public static function mobile()
    {
        return new MobileTransfer();
    }
}