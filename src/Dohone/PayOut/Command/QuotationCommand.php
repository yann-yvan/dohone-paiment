<?php


namespace Dohone\PayOut\Dohone\PayOut\Command;


use Illuminate\Validation\Rule;

class QuotationCommand extends DohoneCommand
{
    private $amount;
    private $method;
    private $currency;
    private $feedsLevel;

    /**
     * QuotationCommand constructor.
     */
    public function __construct()
    {
        $this->setCommand("cotation");
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
     * @return QuotationCommand
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeedsLevel()
    {
        return $this->feedsLevel;
    }

    /**
     * @param mixed $feedsLevel
     * @return QuotationCommand
     */
    public function setFeedsLevel($feedsLevel)
    {
        $this->feedsLevel = $feedsLevel;
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
     * @return QuotationCommand
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
        return empty($this->currency) ? config("dohone.rDvs") : $this->currency;
    }

    /**
     * @param mixed $currency
     * @return QuotationCommand
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }


    protected function toDataArray()
    {
        return [
            'rMt' => $this->getAmount(),
            'rMo' => $this->getMethod(),
            'rDvs' => $this->getCurrency(),
            'rH' => config('dohone.start.rH'),
            'levelFeeds' => $this->getFeedsLevel(),
        ];
    }

    protected function validatorRules()
    {
        return [
            'levelFeeds' => ['required', Rule::in([0, 1, 2, 3, 4])],
            'rMt' => ['required', 'integer'],
            'rDvs' => ['required', Rule::in(['XAF', 'EUR', 'USD'])],
            'rMo' => ['required', Rule::in([self::MTN, self::ORANGE, self::EXPRESS_UNION, self::DOHONE, self::YUP])],
            'rH' => ['required', 'min:8'],
        ];
    }

    protected function responseParser($body)
    {
        return $this->reply(true, $body);
    }

}