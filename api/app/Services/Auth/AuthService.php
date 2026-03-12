<?php

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Models\UserRefreshToken;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{

    public function refresh($refreshToken)
    {
        $token = UserRefreshToken::where('token', $refreshToken)->first();

        if (!$token) {
            throw new ApiException("Refresh token không hợp lệ", 401);
        }

        if ($token->expires_at->isPast()) {
            $token->delete();
            throw new ApiException("Refresh token đã hết hạn", 401);
        }

        $user = $token->user;

        // check user tồn tại
        if (!$user) {
            $token->delete();
            throw new ApiException("Người dùng không tồn tại", 404);
        }

        // tạo access token mới
        $accessToken = JWTAuth::fromUser($user);

        // rotate refresh token (tạo token mới)
        $newRefreshToken = Str::random(64);

        $token->update([
            'token' => $newRefreshToken,
            'expires_at' => now()->addDays(7)
        ]);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
