<?php


namespace Dohone\PayIn\Command;


use Illuminate\Support\Str;

/**
 * Launching the CFRMSMS command is like launching an http request to the DOHONE
 * server, containing certain parameters, via the GET method. This command is used if, for
 * example, it is a payment via DOHONE TRANSFER, or for security reasons. The payment will
 * take place if the confirmation of the SMS is correct (5 attempts maximum).
 *
 * Lancer la commande CFRMSMS revient à lancer une requête http vers le serveur
 * DOHONE, contenant certains paramètres, via la méthode GET. Cette commande est
 * utilisée s’il s’agit par exemple d’un paiement via VIREMENT DOHONE, ou par mesure de
 * sécurité. Le paiement se passera si la confirmation du SMS est correcte (5 essais
 * maximum).
 *
 * Class SMSConfirmCommand
 * @package Dohone\PayOut\Dohone\PayOut\Command
 */
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

    protected function toDataArray()
    {
        return [
            'rT' => $this->getPhone(),
            'rCS' => $this->getCode(),
        ];
    }

    /**
     * The telephone number that was used for the mobile payment money
     *
     * Le numéro de téléphone qui a servi au paiement mobile money
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * The telephone number that was used for the mobile payment money
     *
     * Le numéro de téléphone qui a servi au paiement mobile money
     *
     * @param mixed $phone
     *
     * @return SMSConfirmCommand
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * The code that your customer has received by SMS
     *
     * Le code que votre client a reçu par SMS
     *
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * The code that your customer has received by SMS
     *
     * Le code que votre client a reçu par SMS
     *
     * @param mixed $code
     *
     * @return SMSConfirmCommand
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    protected function validatorRules()
    {
        return [
            'rT' => ['required'],
            'rCS' => ['required'],
        ];
    }

    protected function responseParser($body, $httpClient)
    {
        return self::reply(Str::contains(explode(':', $body)[0], 'OK'), $body);
    }


}