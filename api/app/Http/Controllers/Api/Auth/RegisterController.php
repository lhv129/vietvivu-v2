<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterController extends BaseController
{
    protected $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->service->register($request->validated(), $request->file('avatar'), $request->file('bgImage'));

        return $this->responseCommon(true, 'Đăng ký thành công', $result, 200);
    }
}
