<?php
return [
    /*
     * Start transaction
     *
     * rLocale : le choix de la langue. fr ou en
     *
      method : Ceci est optionnel. Si vous souhaitez que votre API n’affiche que certains opérateurs,
      vous pouvez préciser ces opérateurs ici. 1=MTN, 2=Orange, 3=Express Union, 5=Visa via UBA,
      10=Dohone, 14= Visa via Wari,15=Wari card,16=VISA/MASTERCARD, 17=YUP.
     */

    'merchantToken' => 'XXXXXXXX',
    'currency' => 'XAF',
    'projectName' => env('APP_NAME', "Dohone"),
    'projectLogo' => 'assets/images/logo.png',
    'endPage' => env('APP_URL', "http://localhost"),
    'payInNotifyPage' => env('APP_URL', "http://localhost"),
    'cancelPage' => env('APP_URL', "http://localhost"),
    'language' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | METHOD OF PAYMENT
    |--------------------------------------------------------------------------
    |
    | Ceci est optionnel. Si vous souhaitez que votre API n’affiche que certains opérateurs,
    | vous pouvez préciser ces opérateurs ici. 1=MTN, 2=Orange, 3=Express Union, 5=Visa via UBA,
    | 10=Dohone, 14= Visa via Wari,15=Wari card,16=VISA/MASTERCARD, 17=YUP.
    |
    */
    'method' => '1, 2, 3, 10, 17',



    'numberNotifs' => 5,
    'payInUrl' => env("DOHONE_SANDBOX",false) ? 'https://www.my-dohone.com/dohone-sandbox/pay' : 'https://www.my-dohone.com/dohone/pay',

    'payOutHashCode' => 'XXXXXXXX',
    'payOutPhoneAccount' => 'XXXXXXXX',
    'payOutNotifyPage' => env('APP_URL', "http://localhost"),
    'payOutUrl' => env("DOHONE_SANDBOX",false) ? 'https://www.my-dohone.com/dohone-sandbox/transfertDOHONE' : 'https://www.my-dohone.com/dohone/transfert',
];