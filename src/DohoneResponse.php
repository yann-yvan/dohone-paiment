<?php


namespace Dohone;


class DohoneResponse
{
    private $success;
    private $message;
    private $shouldVerify;
    private $payment_url;
    private $errors;

    /**
     * DohoneResponse constructor.
     *
     * @param      $success
     * @param      $message
     * @param null $errors
     * @param bool $shouldVerify
     * @param      $payment_url
     */
    public function __construct($success, $message, $errors = null, $shouldVerify = false, $payment_url = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->shouldVerify = $shouldVerify;
        $this->payment_url = $payment_url;
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return false|mixed
     */
    public function shouldVerifySMS()
    {
        return $this->shouldVerify;
    }

    /**
     * @return mixed|null
     */
    public function getPaymentUrl()
    {
        return $this->payment_url;
    }

    /**
     * @return null
     */
    public function getErrors()
    {
        return $this->errors;
    }
}