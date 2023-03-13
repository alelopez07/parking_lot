<?php

namespace App\Models;

class EntranceResponse {
    public $entranceId;
    public array $comments;
    public bool $response;
    public string $message;

    function setMessage($value) {
        $this->message = $value;
    }

    function setResponse($value) {
        $this->response = $value;
    }

    public function setEntranceId($id) {
        $this->entranceId = $id;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }
}