<?php


namespace Dohone\PayIn\Command;


use Exception;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Launching the START command is equivalent to launching an http request to the
 * DOHONE server, containing certain parameters, via the GET method.
 *
 * Lancer la commande START revient à lancer une requête http vers le serveur DOHONE,
 * contenant certains paramètres, via la méthode GET.
 *
 * Class StartCommandAPI
 * @package Dohone\PayOut\Dohone\PayOut\Command
 */
class StartCommandAPI extends StartCommand
{
    private $method;
    private $OTPCode;

    protected function validatorRules()
    {
        return array_merge(parent::validatorRules(), [
            'rMo' => ['required', Rule::in([self::MTN, self::ORANGE, self::EXPRESS_UNION, self::DOHONE, self::YUP])],
            'rOTP' => Rule::requiredIf($this->getMethod() == 2),
        ]);
    }

    /**
     * The type of payment the customer will choose to make. The value is numerical. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union Mobile, [10] = DOHONE
     * transfer.
     *
     * le type de paiement que le client choisira d’effectuer. La valeur est numérique. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union mobile, [10] = virement
     * DOHONE.
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * The type of payment the customer will choose to make. The value is numerical. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union Mobile, [10] = DOHONE
     * transfer.
     *
     * le type de paiement que le client choisira d’effectuer. La valeur est numérique. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union mobile, [10] = virement
     * DOHONE.
     *
     * @param mixed $method
     *
     * @return StartCommandAPI
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    protected function toDataArray()
    {
        return array_merge(parent::toDataArray(), [
            'rMo' => $this->getMethod(),
            'rOTP' => $this->getOTPCode(),
        ]);
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
     *
     * @return StartCommandAPI
     */
    public function setOTPCode($OTPCode)
    {
        $this->OTPCode = $OTPCode;
        return $this;
    }

    protected function responseParser($body, $httpClient)
    {
        try {
            $resSplit = explode(':', $body);
            return self::reply(Str::contains($resSplit[0], 'OK'), join(":", $resSplit), null, Str::contains(join(":", $resSplit), 'SMS'));
        }catch (Exception $exception){
            return $this->reply(false,$body);
        }
    }
}