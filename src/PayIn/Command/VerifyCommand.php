<?php


namespace Dohone\PayIn\Command;


use Illuminate\Validation\Rule;

/**
 * Your system will certainly need to verify the success of the payment transaction before providing
 * the service to your customer. Literally, this command literally asks DOHONE: « Do you recognise
 * a transaction with a transaction reference number of XXX, a transaction amount of XXX,
 * and a transaction number of XXX? ».
 *
 * Votre système aura certainement besoin de vérifier l’effectivité du succès de l’opération de
 * paiement, avant de rendre le service à votre client. Littéralement, cette commande demande à
 * DOHONE :
 * « reconnaissez-vous une transaction dont la référence de transaction sur dohone est XXX,
 * dont le montant est XXX, et dont le numero de ma farure est XXX ».
 *
 * Class VerifyCommand
 * @package Dohone\PayOut\Dohone\PayOut\Command
 */
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

    protected function toDataArray()
    {
        return [
            'idReqDoh' => $this->getPaymentToken(),
            'rI' => $this->getCommandID(),
            'rMt' => $this->getAmount(),
            'rDvs' => $this->getCurrency(),
            'rH' => $this->getMerchantToken(),
        ];
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
     * @return VerifyCommand
     */
    public function setCommandID($commandID)
    {
        $this->commandID = $commandID;
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
     * @return VerifyCommand
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * The currency corresponding to the amount. You can choose between 3 currencies
     * only: EUR, XAF, USD
     *
     * La devise correspondante au montant. Vous avez le choix entre 3 devises
     * uniquement : EUR, XAF, USD
     *
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
     * La devise correspondante au montant. Vous avez le choix entre 3 devises
     * uniquement : EUR, XAF, USD
     *
     * @param mixed $currency
     *
     * @return VerifyCommand
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    protected function validatorRules()
    {
        return [
            'idReqDoh' => ['required'],
            'rMt' => ['required', 'integer'],
            'rDvs' => ['required', Rule::in(['XAF', 'EUR', 'USD'])],
            'rI' => ['required'],
        ];
    }

    protected function responseParser($body, $httpClient)
    {
        return $this->reply($body == 'OK', $body);
    }
}