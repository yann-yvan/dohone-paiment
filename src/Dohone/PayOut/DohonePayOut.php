<?php


namespace Dohone\PayOut\Dohone\PayOut;


use Dohone\PayOut\Dohone\PayOut\Command\QuotationCommand;
use Dohone\PayOut\Dohone\PayOut\Command\SMSConfirmCommand;
use Dohone\PayOut\Dohone\PayOut\Command\StartCommandAPI;
use Dohone\PayOut\Dohone\PayOut\Command\StartCommandUI;
use Dohone\PayOut\Dohone\PayOut\Command\VerifyCommand;

class  DohonePayOut
{
    public static function payWithAPI()
    {
        return new StartCommandAPI();
    }

    public static function payWithUI()
    {
        return new StartCommandUI();
    }

    public static function sms()
    {
        return new SMSConfirmCommand();
    }

    public static function verify()
    {
        return new VerifyCommand();
    }

    public static function quotation()
    {
        return new QuotationCommand();
    }
}