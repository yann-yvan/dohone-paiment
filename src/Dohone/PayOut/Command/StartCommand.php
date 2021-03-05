<?php


namespace Dohone\PayOut\Dohone\PayOut\Command;


use Illuminate\Validation\Rule;

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
    private $projectLogo;
    private $projectName;
    private $numberNotifyAttempt;
    private $endPage;
    private $cancelPage;
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
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
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
        return empty($this->language) ? config("dohone.rLocal") : $this->language;
    }

    /**
     * @param mixed $language
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
     * @return StartCommand
     */
    public function setClientPhone($clientPhone)
    {
        $this->clientPhone = $clientPhone;
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
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @param mixed $clientEmail
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
    public function getEndPage()
    {
        return empty($this->endPage) ? config("dohone.endPage") : $this->endPage;
    }

    /**
     * @param mixed $endPage
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
    public function getCancelPage()
    {
        return empty($this->cancelPage) ? config("dohone.cancelPage") : $this->cancelPage;
    }

    /**
     * @param mixed $cancelPage
     * @return StartCommand
     */
    public function setCancelPage($cancelPage)
    {
        $this->cancelPage = $cancelPage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyPage()
    {
        return empty($this->notifyPage) ? config("dohone.notifyPage") : $this->notifyPage;
    }

    /**
     * @param mixed $notifyPage
     * @return StartCommand
     */
    public function setNotifyPage($notifyPage)
    {
        $this->notifyPage = $notifyPage;
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
    public function getCurrency()
    {
        return empty($this->currency) ? config("dohone.rDvs") : $this->currency;
    }

    /**
     * @param mixed $currency
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
    public function getProjectLogo()
    {
        return empty($this->projectLogo) ? config("dohone.logo") : $this->projectLogo;
    }

    /**
     * @param mixed $projectLogo
     * @return StartCommand
     */
    public function setProjectLogo($projectLogo)
    {
        $this->projectLogo = $projectLogo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProjectName()
    {
        return empty($this->projectName) ? config("dohone.source") : $this->projectName;
    }

    /**
     * @param mixed $projectName
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

    protected function validatorRules()
    {
        return [
            'rMt' => ['required', 'integer'],
            'rDvs' => ['required', Rule::in(['XAF', 'EUR', 'USD'])],
            'source' => ['required', 'string'],
            'logo' => ['url'],
            'endPage' => ['required', 'url'],
            'notifyPage' => ['required', 'url'],
            'cancelPage' => ['required', 'url'],
            'rN' => ['nullable', 'string'],
            'numberNotifs' => ['nullable', 'integer'],
            'rLocale' => ['required', Rule::in(['fr', 'en'])],
            'rT' => ['required'],
            'rE' => ['required', 'email'],
            'rH' => ['required', 'min:8'],
        ];
    }

    protected function toDataArray()
    {
        return [
            'rDvs' => $this->getCurrency(),
            'source' => $this->getProjectName(),
            'logo' => $this->getProjectLogo(),
            'rN' => $this->getClientName(),
            'rLocale' => (strcmp($this->getLanguage(), 'default') == 0 ? config('dohone.start.rLocale') : $this->getLanguage()),
            'rT' => $this->getClientPhone(),
            'rMt' => $this->getAmount(),
            'rH' => config("dohone.rH"),
            'rUserId' => $this->clientID,
            'numberNotifs' => config("dohone.numberNotifs"),
            'rE' => $this->getClientEmail(),
            'rI' => $this->getCommandID(),
            'motif' => $this->getDescription(),
            'endPage' => $this->getEndPage(),
            'notifyPage' => $this->getNotifyPage(),
            'cancelPage' => $this->getCancelPage(),
        ];
    }
}