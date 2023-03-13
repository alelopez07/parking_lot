<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends ApiController {

    use ApiResponse;
    protected $repository;

    /**
     * Initialize repository 
     * 
     * @param UserInterface $repositoryImpl
     */
    public function __construct(UserInterface $repositoryImpl) {
        $this->repository = $repositoryImpl;
    }

    /**
     * createUser
     * 
     * Allow root user to create a new user.
     * 
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function createUser(UserRequest $request): JsonResponse {
        $validated = $request->validated();
        $created = $this->repository->newUser($validated);
        if ($created->response) {
            $result = new \stdClass();
            $result->response = true;
            $result->message = "user created successfully.";
            $result->token = $created->token;
            return $this->createdResponse($result);
        } else {
            return $this->errorResponse(null, "an error ocurred");
        }
    }

}