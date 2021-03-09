<?php


namespace Dohone\PayIn;


use Dohone\PayIn\Command\QuotationCommand;
use Dohone\PayIn\Command\SMSConfirmCommand;
use Dohone\PayIn\Command\StartCommandAPI;
use Dohone\PayIn\Command\StartCommandUI;
use Dohone\PayIn\Command\VerifyCommand;

class  DohonePayIn
{
    /**
     * Launching the START command is equivalent to launching an http request to the
     * DOHONE server, containing certain parameters, via the GET method.
     *
     * Lancer la commande START revient à lancer une requête http vers le serveur DOHONE,
     * contenant certains paramètres, via la méthode GET.
     *
     * @return StartCommandAPI
     */
    public static function payWithAPI()
    {
        return new StartCommandAPI();
    }

    /**
     * Launching the START command is equivalent to launching an http request to the
     * DOHONE server, containing certain parameters, via the GET method.
     *
     * Lancer la commande START revient à lancer une requête http vers le serveur DOHONE,
     * contenant certains paramètres, via la méthode GET.
     *
     * @return StartCommandUI
     */
    public static function payWithUI()
    {
        return new StartCommandUI();
    }

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
     * @return SMSConfirmCommand
     */
    public static function sms()
    {
        return new SMSConfirmCommand();
    }

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
     * @return VerifyCommand
     */
    public static function verify()
    {
        return new VerifyCommand();
    }

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
     * @return QuotationCommand
     */
    public static function quotation()
    {
        return new QuotationCommand();
    }
}