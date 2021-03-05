<?php


namespace Dohone\PayOut\Dohone\PayOut\Command;


use Illuminate\Validation\Rule;

class VerifyCommand extends DohoneCommand
{
    private $amount;
    private $commandID;
    private $currency;
    private $paymentToken;

    /**
     * VerifyCommand constructor.
     */
    public function __construct()
    {
        $this->setCommand("verify");
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return VerifyCommand
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommandID()
    {
        return $this->commandID;
    }

    /**
     * @param mixed $commandID
     * @return VerifyCommand
     */
    public function setCommandID($commandID)
    {
        $this->commandID = $commandID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return empty($this->currency) ? config("dohone.rDvs") : $this->currency;
    }

    /**
     * @param mixed $currency
     * @return VerifyCommand
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentToken()
    {
        return $this->paymentToken;
    }

    /**
     * @param mixed $paymentToken
     */
    public function setPaymentToken($paymentToken)
    {
        $this->paymentToken = $paymentToken;
        return $this;
    }

    protected function toDataArray()
    {
        return [
            'idReqDoh' => $this->getPaymentToken(),
            'rI' => $this->getCommandID(),
            'rMt' => $this->getAmount(),
            'rDvs' => $this->getCurrency(),
            'rH' => config('dohone.rH'),
        ];
    }

    protected function validatorRules()
    {
        return [
            'idReqDoh' => ['required'],
            'rMt' => ['required', 'integer'],
            'rDvs' => ['required', Rule::in(['XAF', 'EUR', 'USD'])],
            'rI' => ['required'],
            'rH' => ['required', 'min:8'],
        ];
    }

    protected function responseParser($body)
    {
        return $this->reply($body == 'OK', $body);
    }
}