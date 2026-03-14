<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;

class LoginController extends BaseController
{
    protected $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $result = $this->service->login($request->validated());

        return $this->responseCommon(true, 'Đăng nhập thành công', $result, 200);
    }
}
