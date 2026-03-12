<?php

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Repositories\Auth\LoginRepository;
use App\Services\Auth\UserRefreshTokenService;
use App\Services\BaseService;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginService extends BaseService
{
    protected $userRefreshTokenService;

    public function __construct(
        LoginRepository $repository,
        UserRefreshTokenService $userRefreshTokenService
    ) {
        parent::__construct($repository);
        $this->userRefreshTokenService = $userRefreshTokenService;
    }

    public function login(array $data)
    {
        if (!$token = JWTAuth::attempt($data)) {
            throw new ApiException('Email hoặc mật khẩu không đúng', 404);
        }

        $user = JWTAuth::user();

        $refreshToken = $this->userRefreshTokenService->handle($user->id);

        return [
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
