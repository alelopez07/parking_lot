<?php

namespace App\Interfaces;
use App\Http\Requests\UserRequest;

interface UserInterface
{
    public function newUser(array $request);
}
