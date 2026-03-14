<?php

namespace App\Repositories;

use App\Models\RoomType;

class RoomTypeRepository extends BaseRepository
{
    public function __construct(RoomType $model)
    {
        parent::__construct($model);
    }

    /**
     * Lấy danh sách room type của một hotel
     */
    public function getByHotel($hotelId)
    {
        return $this->model
            ->active()
            ->where('hotel_id', $hotelId)
            ->get();
    }
}
