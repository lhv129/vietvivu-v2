<?php

namespace App\Repositories;

use App\Models\HouseRule;
use App\Repositories\BaseRepository;

class HouseRuleRepository extends BaseRepository
{
    public function __construct(HouseRule $model)
    {
        parent::__construct($model);
    }
}