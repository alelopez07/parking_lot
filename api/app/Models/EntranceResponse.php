<?php

namespace App\Models;

class EntranceResponse extends BaseResponse {
    public $entranceId;
    public string $comments;

    public function setEntranceId($id) {
        $this->entranceId = $id;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }
}