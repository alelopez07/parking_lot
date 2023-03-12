<?php

namespace App\Http\Controllers\v1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as ApiController;

class AuthController extends ApiController
{
    use AuthorizesRequests, ValidatesRequests;
}
