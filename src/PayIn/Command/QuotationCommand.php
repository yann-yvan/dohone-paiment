<?php


namespace Dohone\PayIn\Command;


use Illuminate\Validation\Rule;

/**
 * This command allows you to query DOHONE, to find out what is the total amount you need to
 * inform your customer that he is about to spend, so that he can pay your bill + charges.
 * This command does not exist on the WEB version of the DOHONE API, because it is implicit in it;
 * because the amounts are directly displayed to the Internet user on the screen.
 *
 * Cette commande vous permet d’interroger DOHONE, pour savoir quel est le montant
 * total que vous devez informer à votre client qu’il s’apprête à dépenser, afin qu’il puisse
 * payer votre facture + les frais. Cette commande n’existe pas sur la version WEB de l’API DOHONE, car elle y est
 * implicite ; car les montants sont directement affichés à l’internaute sur l’écran.
 *
 * Class QuotationCommand
 * @package Dohone\PayOut\Dohone\PayOut\Command
 */
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

    protected function toDataArray()
    {
        return [
            'rMt' => $this->getAmount(),
            'rMo' => $this->getMethod(),
            'rDvs' => $this->getCurrency(),
            'rH' => $this->getMerchantToken(),
            'levelFeeds' => $this->getFeedsLevel(),
        ];
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
     * @return QuotationCommand
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * The type of payment the customer will choose to make. The value is numerical. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union Mobile, [10] = DOHONE transfer
     *
     * le type de paiement que le client choisira d’effectuer. La valeur est numérique. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union mobile, [10] = virement DOHONE.
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * The type of payment the customer will choose to make. The value is numerical. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union Mobile, [10] = DOHONE transfer
     *
     * le type de paiement que le client choisira d’effectuer. La valeur est numérique. [1] =
     * MTN-Money, [2] = Orange-Money, [3] = Express-Union mobile, [10] = virement DOHONE.
     *
     * @param mixed $method
     *
     * @return QuotationCommand
     */
    public function setMethod($method)
    {
        $this->method = $method;
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
     * @return QuotationCommand
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * The level of information you wish to receive in return (numerical value):
     *  0 = Purchase amount + Operator fees + customer online DOHONE fee
     *  1 = Purchase amount + Operator fees
     *  2 = Purchase amount + DOHONE fee for the customer's online purchase
     *  3 = Purchase amount + DOHONE merchant online sales fee
     *  4 = Purchase amount + Merchant's DOHONE online sales fee + Operator fees
     *
     * Le niveau de d’information de cotation que vous souhaitez avoir en retour (valeur
     * numérique) :
     *  0 = Montant achat + Frais opérateur + frais DOHONE d’achat en ligne du
     * client
     *  1 = Montant achat + Frais d’opérateur
     *  2 = Montant achat + Frais DOHONE d’achat en ligne du client
     *  3 = Montant achat + Frais DOHONE de vente en ligne du marchand
     *  4 = Montant achat + Frais DOHONE de vente en ligne du marchand + Frais d’opérateurs
     *
     * @return mixed
     */
    public function getFeedsLevel()
    {
        return $this->feedsLevel;
    }

    /**
     * The level of information you wish to receive in return (numerical value):
     *  0 = Purchase amount + Operator fees + customer online DOHONE fee
     *  1 = Purchase amount + Operator fees
     *  2 = Purchase amount + DOHONE fee for the customer's online purchase
     *  3 = Purchase amount + DOHONE merchant online sales fee
     *  4 = Purchase amount + Merchant's DOHONE online sales fee + Operator fees
     *
     * Le niveau de d’information de cotation que vous souhaitez avoir en retour (valeur
     * numérique) :
     *  0 = Montant achat + Frais opérateur + frais DOHONE d’achat en ligne du
     * client
     *  1 = Montant achat + Frais d’opérateur
     *  2 = Montant achat + Frais DOHONE d’achat en ligne du client
     *  3 = Montant achat + Frais DOHONE de vente en ligne du marchand
     *  4 = Montant achat + Frais DOHONE de vente en ligne du marchand + Frais d’opérateurs
     *
     * @param mixed $feedsLevel
     *
     * @return QuotationCommand
     */
    public function setFeedsLevel($feedsLevel)
    {
        $this->feedsLevel = $feedsLevel;
        return $this;
    }

    protected function validatorRules()
    {
        return [
            'levelFeeds' => ['required', Rule::in([0, 1, 2, 3, 4])],
            'rMt' => ['required', 'integer'],
            'rDvs' => ['required', Rule::in(['XAF', 'EUR', 'USD'])],
            'rMo' => ['required', Rule::in([self::MTN, self::ORANGE, self::EXPRESS_UNION, self::DOHONE, self::YUP])],
        ];
    }

    protected function responseParser($body, $httpClient = null)
    {
        return $this->reply(true, $body);
    }

}