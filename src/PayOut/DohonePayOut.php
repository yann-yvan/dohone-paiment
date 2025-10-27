<?php


namespace Dohone\PayOut;


use Dohone\PayOut\Transfer\CardTransfer;
use Dohone\PayOut\Transfer\MobileTransfer;

class DohonePayOut
{
    const MTN = 5;
    const ORANGE = 6;
    const EXPRESS_UNION = 3;
    const DOHONE = 1;
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