<?php


namespace Dohone\PayOut\Dohone\PayOut\Command;


use Illuminate\Support\Str;

class SMSConfirmCommand extends DohoneCommand
{

    private $phone;
    private $code;

    /**
     * SMSConfirmCommand constructor.
     */
    public function __construct()
    {
        $this->setCommand("cfrmsms");
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }


    protected function toDataArray()
    {
        return [
            'rT' => $this->getPhone(),
            'rCS' => $this->getCode(),
        ];
    }

    protected function validatorRules()
    {
        return [
            'rT' => ['required'],
            'rCS' => ['required'],
        ];
    }

    protected function responseParser($body)
    {
        $resSplit = explode(':', $body);

        return self::reply(Str::contains($resSplit[0], 'OK'), join(":", $resSplit));
    }


}