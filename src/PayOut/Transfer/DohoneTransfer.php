<?php


namespace Dohone\PayOut\Transfer;


use Dohone\DohoneResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

abstract class DohoneTransfer
{
    private $amount;
    private $payerPhoneAccount;
    private $method;
    private $currency;
    private $receiverName;
    private $receiverAccount;
    private $receiverCity;
    private $receiverCountry;
    private $transactionID;
    private $receiverID;
    private $notifyUrl;
    private $hashCode;

    /**
     * @return mixed
     */
    public function getReceiverID()
    {
        return $this->receiverID;
    }

    /**
     * @param mixed $receiverID
     *
     * @return DohoneTransfer
     */
    public function setReceiverID($receiverID)
    {
        $this->receiverID = $receiverID;
        return $this;
    }

    public function post()
    {
        $validator = Validator::make($this->getData(), $this->getRules());
        if ($validator->fails()) {
            return $this->reply(!$validator->fails(), 'Please set all required values listed in errors logs', $validator->errors());
        }

        $response = Http::timeout(100)->get(config('dohone.payOutUrl', "https://www.my-dohone.com/dohone/transfert"), $this->getData());
        $body = mb_convert_encoding($response->body(), 'UTF-8', 'auto');
        if ($response->successful()) {
            return $this->reply(str_contains($body, 'OK'), $body);
        }

        return $this->reply(false, $body);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return [
            'account' => $this->getPayerPhoneAccount(),
            'destination' => $this->getReceiverAccount(),
            'mode' => $this->getMethod(),
            'amount' => $this->getAmount(),
            'transID' => $this->getTransactionID(),
            'devise' => $this->getCurrency(),
            'nameDest' => $this->getReceiverName(),
            'ville' => $this->getReceiverCity(),
            'pays' => $this->getReceiverCountry(),
            'hash' => md5($this->getPayerPhoneAccount() . $this->getMethod() . $this->getAmount() . $this->getCurrency() . $this->getTransactionID() . $this->getHashCode()),
            'notifyUrl' => $this->getNotifyUrl(),
        ];
    }

    /**
     * @return mixed
     */
    public function getPayerPhoneAccount()
    {
        return empty($this->payerPhoneAccount) ? config("dohone.payOutPhoneAccount") : $this->payerPhoneAccount;
    }

    /**
     * @param mixed $payerPhoneAccount
     *
     * @return DohoneTransfer
     */
    public function setPayerPhoneAccount($payerPhoneAccount)
    {
        $this->payerPhoneAccount = $payerPhoneAccount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiverAccount()
    {
        return $this->receiverAccount;
    }

    /**
     * @param mixed $receiverAccount
     *
     * @return DohoneTransfer
     */
    public function setReceiverAccount($receiverAccount)
    {
        $this->receiverAccount = $receiverAccount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     *
     * @return DohoneTransfer
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
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
     *
     * @return DohoneTransfer
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return empty($this->currency) ? config("dohone.currency") : $this->currency;
    }

    /**
     * @param mixed $currency
     *
     * @return DohoneTransfer
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * @param mixed $receiverName
     *
     * @return DohoneTransfer
     */
    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiverCity()
    {
        return $this->receiverCity;
    }

    /**
     * @param mixed $receiverCity
     *
     * @return DohoneTransfer
     */
    public function setReceiverCity($receiverCity)
    {
        $this->receiverCity = $receiverCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiverCountry()
    {
        return $this->receiverCountry;
    }

    /**
     * @param mixed $receiverCountry
     *
     * @return DohoneTransfer
     */
    public function setReceiverCountry($receiverCountry)
    {
        $this->receiverCountry = $receiverCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    /**
     * @param mixed $transactionID
     *
     * @return DohoneTransfer
     */
    public function setTransactionID($transactionID)
    {
        $this->transactionID = $transactionID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHashCode()
    {
        return empty($this->hashCode) ? config("dohone.payOutHashCode") : $this->hashCode;
    }

    /**
     * @param mixed $hashCode
     *
     * @return DohoneTransfer
     */
    public function setHashCode($hashCode)
    {
        $this->hashCode = $hashCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return empty($this->notifyUrl) ? config('dohone.payOutNotifyPage') : $this->notifyUrl;
    }

    /**
     * @param mixed $notifyUrl
     *
     * @return DohoneTransfer
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        return $this;
    }

    protected function getRules()
    {
        return array_merge($this->validatorRules(), [
            'account' => ['required'],
            'destination' => ['required', 'string'],
            'mode' => ['required'],
            'amount' => ['required'],
            'transID' => ['required'],
            'devise' => ['required', 'string'],
            'nameDest' => ['required', 'string'],
            'ville' => ['required', 'string'],
            'pays' => ['required', 'string'],
            'hash' => ['required', 'string'],
            'notifyUrl' => ['required', 'url'],
        ]);
    }

    protected abstract function validatorRules();

    /**
     * @param      $success
     * @param      $message
     * @param      $errors
     * @param bool $codeRequired
     * @param null $redirectUrl
     *
     * @return DohoneResponse
     */
    protected function reply($success, $message, $errors = null, $codeRequired = false, $redirectUrl = null)
    {
        return new DohoneResponse($success, $message, $errors, $codeRequired, $redirectUrl);
    }

}
