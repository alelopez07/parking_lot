<?php

namespace App\Interfaces;

interface UserInterface
{
    /**
     * newUser()
     * Add new user.
     * 
     * @param array $request
     * @return \stdClass
     */
    public function newUser(array $request): \stdClass;
}
