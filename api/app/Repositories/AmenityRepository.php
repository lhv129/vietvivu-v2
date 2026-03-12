<?php

namespace App\Repositories;

use App\Models\Amenity;
use App\Repositories\BaseRepository;

class AmenityRepository extends BaseRepository
{
    public function __construct(Amenity $model)
    {
        parent::__construct($model);
    }
}