<?php
return [
    /*
     * Start transaction
     *
     * rLocale : le choix de la langue. fr ou en
     *
     * rOnly : Ceci est optionnel. Si vous souhaitez que votre API n’affiche que certains opérateurs,
     * vous pouvez préciser ces opérateurs ici. 1=MTN, 2=Orange, 3=Express Union, 5=Visa via UBA,
     * 10=Dohone, 14= Visa via Wari,15=Wari card,16=VISA/MASTERCARD, 17=YUP.
     */

    'rH' => 'XXXXXXXX',
    'rDvs' => 'XAF',
    'source' => env('APP_NAME', "Dohone"),
    'logo' => 'assets/images/logo.png',
    'endPage' => env('APP_URL', "http://localhost"),
    'notifyPage' => env('APP_URL', "http://localhost"),
    'cancelPage' => env('APP_URL', "http://localhost"),
    'rLocale' => 'fr',
    'rOnly' => '1, 2, 3, 5, 10, 14, 15, 16, 17',
    'numberNotifs' => 5,
    'url' => env("DOHONE_SANDBOX") ? 'https://www.my-dohone.com/dohone-sandbox/pay' : 'https://www.my-dohone.com/dohone/pay',
];