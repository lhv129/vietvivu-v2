<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\BaseRepository;

class RegisterRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
