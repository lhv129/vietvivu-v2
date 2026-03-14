<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Repositories\BaseRepository;

class HotelRepository extends BaseRepository
{
    public function __construct(Hotel $model)
    {
        parent::__construct($model);
    }

    public function index($limit = 10)
    {
        return $this->model
            ->with('media')
            ->active()
            ->orderBy('sort_order', 'asc')
            ->paginate($limit);
    }
}
