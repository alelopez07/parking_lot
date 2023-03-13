<?php

namespace App\Http\Controllers\v1;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends ApiController
{
    use ApiResponse;
    use AuthorizesRequests, ValidatesRequests;

    /**
     * authenticate user admin
     * 
     * @param Request $request
     * @return JsonResponse response
     */
    public function authentication(Request $request): JsonResponse {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('parkingLotApi')->plainTextToken; 
            $success['name'] =  $user->name;
            $success['email'] = $user->email;
            $success['response'] = true;
            $success['message'] = 'authentication successfully.';
            return $this->successResponse($success);
        }
        else{ 
            return $this->unauthorizedResponse(true);
        }
    }

    /**
     * remove current access token
     * 
     * @return JsonResponse
     */
    public function logout(): JsonResponse {
        Auth::user()->currentAccessToken()->delete();
        return $this->okResponse(['message' => 'unauthenticated']);
    }
    
}
