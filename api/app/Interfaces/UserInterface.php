<?php

namespace App\Interfaces;

interface UserInterface
{
    /**
     * newUser()
     * Add new user.
     * 
     * @param array $request
     * @return void 
     */
    public function newUser(array $request);
}
