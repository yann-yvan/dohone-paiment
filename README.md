# DOHONE PAYOUT API AND WEB

## If you wish to make your customers pay by Orange Money, MTN Mobile Money, Express Union Mobile or DOHONE transfert, on your mobile application and your website with or without a DOHONE graphic interface, the principle is simple.

## Features

1. Make Quotation
2. Make Payment with Web interface
3. Make Payment without Web interface
4. Make SMS verification
5. Make payment verification

## Usage

### Step 1:

#### Installation (with Composer)

```composer
composer require dohone/payment
```

### Step 2:

#### Configuration

```shell
$ php artisan vendor:publish --provider="Dohone\DohonePayServiceProvider"
```

### Step 3:

#### Update your dohone.php config with your merchand hashcode

```php
return [
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
    'url' => env("DOHONE_SANDBOX",false) ? 'https://www.my-dohone.com/dohone-sandbox/pay' : 'https://www.my-dohone.com/dohone/pay',
];
```

### Step 4: (optional)

#### Enable debugger mode by using sandbox account (Please make sure to delete the line or set it to false in production)

```dotenv
DOHONE_SANDBOX=true
```

## Start using the API

### 1. Make Quotation

```php
$response = DohonePayIn::quotation()
        ->setAmount(123)
        ->setFeedsLevel(4)
        ->setMethod(DohonePayIn::quotation()::MTN)
        ->get();
     if ($response->isSuccess()) {
    //success code goes here
        echo $response->getMessage();
    } else {
    //error code goes here
        echo $response->getMessage();
    }
```


### 2. Make Payment using Web interface

```php
 $builder= DohonePayIn::payWithUI()
        ->setAmount(123)
        ->setClientPhone("695499969")
        ->setClientEmail("yann@email.com")
        ->setCommandID("aazertyuiop");
    try {
         return   $builder->getView();
    }catch (Exception $exception){
        //Return error view
        return $builder->getErrors();
    }
```


### 3. Make Payment without Web interface

```php
$response = DohonePayIn::payWithAPI()
        ->setAmount(123)
        ->setClientPhone("the phone of the user")
        ->setClientEmail("the email of the user")
        ->setCommandID("your order unique id")
        ->setOTPCode(123456)
        ->setMethod(DohonePayIn::quotation()::ORANGE)
        ->get();
     if ($response->isSuccess()) {
    //success code goes here
        echo $response->getMessage();
    } else {
    //error code goes here
        echo $response->getMessage();
    }
```


### 4. Make SMS verification

```php
$response = DohonePayIn::sms()
        ->setCode("the code receive by SMS")
        ->setPhone("the phone which has receive the SMS")
        ->get();
    if ($response->isSuccess()) {
    //success code goes here
        echo $response->getMessage();
    } else {
    //error code goes here
        echo $response->getMessage();
    }
```


### 5. Make payment verification

```php
$response = DohonePayIn::verify()
        ->setAmount(6546545)
        ->setCommandID("your command unique id")
        ->setPaymentToken("the ttoken receive after the successful payment")
        ->get();
    if ($response->isSuccess()) {
    //success code goes here
        echo $response->getMessage();
    } else {
    //error code goes here
        echo $response->getMessage();
    }
```


## Response object method return by each 

*Method* | *Description* 
--- | --- 
isSuccess() |  Is true when there is no error
getMessage() |  Content a description of the response
shouldVerifySMS() |  Return true if a SMS has been send to user for confirmation. Use this method to allow user to enter the code
getPaymentUrl() |  This method return the link generate by ```DohonePayOut::payWithUI()```
getErrors() |  Get all errors catch during execution such as data validation

