<?php


namespace Dohone\PayOut\Dohone\PayOut\Command;


use Dohone\PayOut\Dohone\PayOut\DohoneResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

abstract class  DohoneCommand
{
    const MTN = 1;
    const ORANGE = 2;
    const EXPRESS_UNION = 3;
    const DOHONE = 10;
    const YUP = 17;

    private $command;

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    protected abstract function toDataArray();

    protected abstract function validatorRules();

    protected abstract function responseParser($body);

    public function get()
    {
        $data = $this->toDataArray();
        $data["cmd"] = $this->command;

        $rules = $this->validatorRules();
        $rules["cmd"] = ['required', Rule::in(['start', 'cotation', 'verify', 'cfrmsms'])];

        $validator = Validator::make($this->toDataArray(), $this->validatorRules());
        if ($validator->fails()) {
            return self::reply(!$validator->fails(), $validator->errors());
        }
        $http = Http::get(config('dohone.url',"http"), $data);
        if ($http->successful()) {
            return $this->responseParser($http->body());
        } else {
            return $this->reply(false, $http->body());
        }
    }

    /**
     * @param $success
     * @param $message
     * @param bool $codeRequired
     * @param null $redirectUrl
     * @return DohoneResponse
     */
    protected function reply($success, $message, $codeRequired = false, $redirectUrl = null)
    {
        return new DohoneResponse($success, $message, $codeRequired, $redirectUrl);
    }
}