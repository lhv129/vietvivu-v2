<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{

    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->bearerToken();
        return $this->service->refresh($refreshToken);
    }
}
