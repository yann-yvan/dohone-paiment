<?php


namespace Dohone\PayIn\Command;



use Dohone\DohoneResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

abstract class  DohoneCommand
{
    const MTN = 1;
    const ORANGE = 2;
    const EXPRESS_UNION = 3;
    const DOHONE = 10;
    const YUP = 17;
    private $command;
    private $merchantToken;

    /**
     * Hashcode of your merchant account. The hashcode that was sent to you by email.
     * This setting is optional. But if you benefit from a custom pricing with DOHONE, it is
     * necessary to mention this parameter.
     *
     * Hashcode de votre compte Marchand. Le hashcode qui vous a été transmis par
     * mail. Ce paramètre est facultatif. Mais si vous bénéficiez d’une tarification sur
     * mesure avec DOHONE, il est nécessaire de mentionner ce paramètre.
     *
     * @return mixed
     */
    public function getMerchantToken()
    {
        return empty($this->merchantToken) ? config('dohone.merchantToken') : $this->merchantToken;
    }

    /**
     * Hashcode of your merchant account. The hashcode that was sent to you by email.
     * This setting is optional. But if you benefit from a custom pricing with DOHONE, it is
     * necessary to mention this parameter.
     *
     * Hashcode de votre compte Marchand. Le hashcode qui vous a été transmis par
     * mail. Ce paramètre est facultatif. Mais si vous bénéficiez d’une tarification sur
     * mesure avec DOHONE, il est nécessaire de mentionner ce paramètre.
     *
     * @param mixed $merchantToken
     *
     * @return DohoneCommand
     */
    public function setMerchantToken($merchantToken)
    {
        $this->merchantToken = $merchantToken;
        return $this;
    }

    public function get()
    {
        $validator = Validator::make($this->getData(), $this->getRules());
        if ($validator->fails()) {
            return self::reply(!$validator->fails(), 'Please set all required values listed in errors logs', $validator->errors());
        }

        $http = Http::get(config('dohone.url', "https://www.my-dohone.com/dohone/pay"), $this->getData());
        if ($http->successful()) {
            return $this->responseParser($http->body(), $http);
        } else {
            return $this->reply(false, $http->body());
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return array_merge(['cmd' => $this->command], $this->toDataArray());
    }

    protected abstract function toDataArray();

    protected function getRules()
    {
        $rules = $this->validatorRules();
        $rules["cmd"] = ['required', Rule::in(['start', 'cotation', 'verify', 'cfrmsms'])];

        if (array_key_exists('rH', $this->getData())) {
            $rules['rH'] = ['required', 'min:8'];
        }
        return $rules;
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

    protected abstract function responseParser($body, $httpClient);

    /**
     * @param mixed $command
     */
    protected function setCommand($command)
    {
        $this->command = $command;
    }

    public function getErrors()
    {
        return Validator::make($this->getData(), $this->getRules())->errors();
    }
}