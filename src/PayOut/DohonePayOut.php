<?php


namespace Dohone\PayOut;


use Dohone\PayOut\Transfer\CardTransfer;
use Dohone\PayOut\Transfer\MobileTransfer;

class DohonePayOut
{
    const MTN = 1;
    const ORANGE = 2;
    const EXPRESS_UNION = 3;
    const DOHONE = 10;
    const YUP = 17;

    public static function card()
    {
        return new CardTransfer();
    }

    public static function mobile()
    {
        return new MobileTransfer();
    }
}