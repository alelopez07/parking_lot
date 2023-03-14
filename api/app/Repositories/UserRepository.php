<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    protected $userModel;

    public function newUser(array $request): \stdClass {
        $result = new \stdClass();
        try {
            $user = User::create([
                "name" => $request["name"],
                "email" => $request["email"],
                "password" => Hash::make($request["password"]),
            ]);
            $result->response = true;
            $result->token = $user->createToken("parking-lot-api")->plainTextToken;
            $this->userModel = $user;
        } catch (\Throwable $th) {
            $result->response = false;
            $result->token = null;
        }
        
        return $result;
    }
}
