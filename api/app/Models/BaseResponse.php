<?php

namespace App\Models;

class BaseResponse {
    public bool $response;
    public $message;

    function setMessage($value) {
        $this->message = $value;
    }

    function setResponse($value) {
        $this->response = $value;
    }

}