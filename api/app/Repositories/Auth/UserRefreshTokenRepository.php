<?php

namespace App\Repositories\Auth;

use App\Models\UserRefreshToken;
use App\Repositories\BaseRepository;

class UserRefreshTokenRepository extends BaseRepository
{
    public function __construct(UserRefreshToken $model)
    {
        parent::__construct($model);
    }

    public function findByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }
    
}
