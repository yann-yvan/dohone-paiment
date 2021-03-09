<?php


namespace Dohone\PayIn\Command;

use Illuminate\Support\Facades\Validator;

/**
 * Launching the START command is equivalent to launching an http request to the
 * DOHONE server, containing certain parameters, via the GET method.
 *
 * Lancer la commande START revient à lancer une requête http vers le serveur DOHONE,
 * contenant certains paramètres, via la méthode GET.
 *
 * Class StartCommandUI
 * @package Dohone\PayOut\Dohone\PayOut\Command
 */
class StartCommandUI extends StartCommand
{
    private $projectLogo;
    private $cancelPage;

    /**
     * Get View
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function getView()
    {
        $validator = Validator::make($this->getData(), $this->getRules());
        if ($validator->fails()) {
            throw new \Exception("Please check that all required inputs have been set");
        } else {
            return view("dohone::payment-gate")->with("data", $this->getData());
        }
    }

    protected function responseParser($body, $httpClient)
    {
        return $this->reply(true, 'Redirect to this url', null, false, $httpClient->getBody());
    }

    protected function toDataArray()
    {
        return array_merge(parent::toDataArray(), [
            'logo' => $this->getProjectLogo(),
            'cancelPage' => $this->getCancelPage(),
            'rOnly' =>  config('dohone.method'),
        ]);
    }

    /**
     * @return mixed
     */
    public function getProjectLogo()
    {
        return empty($this->projectLogo) ? config("dohone.projectLogo") : $this->projectLogo;
    }

    /**
     * @param mixed $projectLogo
     *
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
    public function getCancelPage()
    {
        return empty($this->cancelPage) ? config("dohone.cancelPage") : $this->cancelPage;
    }

    /**
     * @param mixed $cancelPage
     *
     * @return StartCommand
     */
    public function setCancelPage($cancelPage)
    {
        $this->cancelPage = $cancelPage;
        return $this;
    }

    protected function validatorRules()
    {
        return array_merge(parent::validatorRules(), [
            'logo' => ['required', 'url'],
            'cancelPage' => ['required', 'url'],
            'rOnly' => ['required', 'string'],
        ]);
    }

    public function get()
    {
        return $this->reply(false, "Please use the getView() method instead !!!!");
    }
}