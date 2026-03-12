<?php

namespace App\Repositories;

use App\Models\Facility;
use App\Repositories\BaseRepository;

class FacilityRepository extends BaseRepository
{
    public function __construct(Facility $model)
    {
        parent::__construct($model);
    }
}
