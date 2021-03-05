<?php


namespace Dohone\PayOut\Dohone\PayOut\Command;


use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StartCommandAPI extends StartCommand
{
    private $method;
    private $OTPCode;

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return StartCommandAPI
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOTPCode()
    {
        return $this->OTPCode;
    }

    /**
     * @param mixed $OTPCode
     * @return StartCommandAPI
     */
    public function setOTPCode($OTPCode)
    {
        $this->OTPCode = $OTPCode;
        return $this;
    }


    protected function validatorRules()
    {
        return array_merge(parent::validatorRules(), [
            'rMo' => ['required', Rule::in([self::MTN, self::ORANGE, self::EXPRESS_UNION, self::DOHONE, self::YUP])],
            'rOTP' => Rule::requiredIf($this->getMethod() == 2),
        ]);
    }

    protected function toDataArray()
    {
        return array_merge(parent::toDataArray(), [
            'rMo' => $this->getMethod(),
            'rOTP' => $this->getOTPCode(),
        ]);
    }

    protected function responseParser($body)
    {
        $resSplit = explode(':', $body);
        return self::reply(Str::contains($resSplit[0], 'OK'), join(":", $resSplit), Str::contains(join(":", $resSplit), 'SMS'));
    }
}