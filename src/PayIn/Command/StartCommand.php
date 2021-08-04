<?php


namespace Dohone\PayIn\Command;


use Illuminate\Validation\Rule;

/**
 * Launching the START command is equivalent to launching an http request to the
 * DOHONE server, containing certain parameters, via the GET method.
 *
 * Lancer la commande START revient à lancer une requête http vers le serveur DOHONE,
 * contenant certains paramètres, via la méthode GET.
 *
 * Class StartCommand
 * @package Dohone\PayOut\Dohone\PayOut\Command
 */
abstract class StartCommand extends DohoneCommand
{
    private $clientID;
    private $clientName;
    private $clientPhone;
    private $clientEmail;
    private $language;
    private $amount;
    private $commandID;
    private $currency;
    private $description;
    private $projectName;
    private $numberNotifyAttempt;
    private $endPage;
    private $notifyPage;

    /**
     * StartCommand constructor.
     */
    public function __construct()
    {
        $this->setCommand("start");
    }

    /**
     * @return mixed
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @param mixed $clientID
     *
     * @return StartCommand
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
        return $this;
    }

    protected function validatorRules()
    {
        return [
            'rMt' => ['required', 'integer'],
            'rDvs' => ['required', Rule::in(['XAF', 'EUR', 'USD'])],
            'source' => ['required', 'string'],
            'endPage' => ['required', 'url'],
            'notifyPage' => ['required', 'url'],
            'rN' => ['nullable', 'string'],
            'numberNotifs' => ['nullable', 'integer'],
            'rLocale' => ['required', Rule::in(['fr', 'en'])],
            'rT' => ['required'],
            'rE' => ['required', 'email'],
        ];
    }

    protected function toDataArray()
    {
        return [
            'rDvs' => $this->getCurrency(),
            'source' => $this->getProjectName(),
            'rN' => $this->getClientName(),
            'rLocale' => $this->getLanguage(),
            'rT' => $this->getClientPhone(),
            'rMt' => $this->getAmount(),
            'rH' => $this->getMerchantToken(),
            'rUserId' => $this->clientID,
            'numberNotifs' => $this->getNumberNotifyAttempt(),
            'rE' => $this->getClientEmail(),
            'rI' => $this->getCommandID(),
            'motif' => $this->getDescription(),
            'endPage' => $this->getEndPage(),
            'notifyPage' => $this->getNotifyPage(),
        ];
    }

    /**
     * The currency corresponding to the amount. You can choose between 3 currencies
     * only: EUR, XAF, USD
     * @return mixed
     */
    public function getCurrency()
    {
        return empty($this->currency) ? config("dohone.currency") : $this->currency;
    }

    /**
     * The currency corresponding to the amount. You can choose between 3 currencies
     * only: EUR, XAF, USD
     *
     * @param mixed $currency
     *
     * @return StartCommand
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProjectName()
    {
        return empty($this->projectName) ? config("dohone.projectName") : $this->projectName;
    }

    /**
     * @param mixed $projectName
     *
     * @return StartCommand
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     *
     * @return StartCommand
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return empty($this->language) ? config("dohone.language") : $this->language;
    }

    /**
     * @param mixed $language
     *
     * @return StartCommand
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientPhone()
    {
        return $this->clientPhone;
    }

    /**
     * @param mixed $clientPhone
     *
     * @return StartCommand
     */
    public function setClientPhone($clientPhone)
    {
        $this->clientPhone = $clientPhone;
        return $this;
    }

    /**
     * TOTAL net amount of purchases
     *
     * Montant TOTAL net des achats
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * TOTAL net amount of purchases
     *
     * Montant TOTAL net des achats
     *
     * @param mixed $amount
     *
     * @return StartCommand
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberNotifyAttempt()
    {
        return empty($this->numberNotifyAttempt) ? config("dohone.numberNotifs") : $this->numberNotifyAttempt;
    }

    /**
     * @param mixed $numberNotifyAttempt
     */
    public function setNumberNotifyAttempt($numberNotifyAttempt)
    {
        $this->numberNotifyAttempt = $numberNotifyAttempt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @param mixed $clientEmail
     *
     * @return StartCommand
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;
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
     *
     * @return StartCommand
     */
    public function setCommandID($commandID)
    {
        $this->commandID = $commandID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return StartCommand
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndPage()
    {
        return empty($this->endPage) ? config("dohone.endPage") : $this->endPage;
    }

    /**
     * @param mixed $endPage
     *
     * @return StartCommand
     */
    public function setEndPage($endPage)
    {
        $this->endPage = $endPage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyPage()
    {
        return empty($this->notifyPage) ? config("dohone.payInNotifyPage") : $this->notifyPage;
    }

    /**
     * @param mixed $notifyPage
     *
     * @return StartCommand
     */
    public function setNotifyPage($notifyPage)
    {
        $this->notifyPage = $notifyPage;
        return $this;
    }

}