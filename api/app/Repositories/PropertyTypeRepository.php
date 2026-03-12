<?php

namespace App\Repositories;

use App\Models\PropertyType;
use App\Repositories\BaseRepository;

class PropertyTypeRepository extends BaseRepository
{
    public function __construct(PropertyType $model)
    {
        parent::__construct($model);
    }
}
