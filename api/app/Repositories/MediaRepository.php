<?php

namespace App\Repositories;

use App\Models\Media;
use App\Repositories\BaseRepository;

class MediaRepository extends BaseRepository
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }


    public function getByMediable(string $type, int $id)
    {
        return $this->model
            ->where('mediable_type', $type)
            ->where('mediable_id', $id)
            ->get();
    }

    public function deleteByMediable($type, $id)
    {
        return $this->model
            ->where('mediable_type', $type)
            ->where('mediable_id', $id)
            ->delete();
    }

    public function forceDelete($model)
    {
        return $model->forceDelete();
    }
}
