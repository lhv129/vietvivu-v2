<?php

namespace App\Services\Auth;


use App\Repositories\Auth\UserRefreshTokenRepository;
use App\Services\BaseService;
use Illuminate\Support\Str;

/**
 * @extends BaseService<\App\Repositories\Auth\UserRefreshTokenRepository>
 */
class UserRefreshTokenService extends BaseService
{
    public function __construct(UserRefreshTokenRepository $repository)
    {
        parent::__construct($repository);
    }

    public function handle($userId)
    {
        $refresh = $this->repository->findByUserId($userId);

        if (!$refresh) {

            $token = Str::random(64);

            $this->repository->create([
                'user_id' => $userId,
                'token' => $token,
                'expires_at' => now()->addDays(7)
            ]);

            return $token;
        }

        if ($refresh->expires_at->isPast()) {

            $token = Str::random(64);

            $this->repository->update($refresh, [
                'token' => $token,
                'expires_at' => now()->addDays(7)
            ]);

            return $token;
        }

        return $refresh->token;
    }
}
