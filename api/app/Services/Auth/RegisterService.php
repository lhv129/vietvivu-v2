<?php

namespace App\Services\Auth;

use App\Helpers\ImageHelper;
use App\Repositories\Auth\RegisterRepository;
use App\Services\Auth\UserRefreshTokenService;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterService extends BaseService
{
    protected UserRefreshTokenService $refreshTokenService;

    public function __construct(
        RegisterRepository $repository,
        UserRefreshTokenService $refreshTokenService
    ) {
        parent::__construct($repository);
        $this->refreshTokenService = $refreshTokenService;
    }

    public function register(array $data, $avatar = null, $bgImage = null)
    {
        $uploadedAvatar = null;
        $uploadedBgImage = null;

        try {
            DB::beginTransaction();

            // 1 display_name = Họ + Tên
            $data['display_name'] = trim($data['last_name'] . ' ' . $data['first_name']);

            // 2 role mặc định
            $data['role_id'] = 3;

            // 3 hash password
            $data['password'] = Hash::make($data['password']);

            // 4 upload avatar
            if ($avatar) {
                $uploadedAvatar = ImageHelper::uploadSingle(
                    $avatar,
                    'avatars'
                );

                $data['avatar'] = $uploadedAvatar;
            }

            // 5 upload bgImage
            if ($bgImage) {
                $uploadedBgImage = ImageHelper::uploadSingle(
                    $bgImage,
                    'bg_images'
                );

                $data['bg_image'] = $uploadedBgImage;
            }

            // 6 tạo user
            $user = $this->repository->create($data);

            // 7 tạo JWT access_token
            $token = JWTAuth::fromUser($user);

            // 8 Tạo JWT refresh_token
            $refreshToken = $this->refreshTokenService->handle($user->id);

            DB::commit();

            return [
                'access_token' => $token,
                'refresh_token' => $refreshToken,
                'user' => $user,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ];
        } catch (\Throwable $e) {

            DB::rollBack();

            // Xóa avatar nếu upload rồi
            if ($uploadedAvatar) {
                ImageHelper::delete($uploadedAvatar);
            }

            // Xóa bgImage nếu upload rồi
            if ($uploadedBgImage) {
                ImageHelper::delete($uploadedBgImage);
            }

            throw $e;
        }
    }
}
