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

    public function getByHotelSlug(string $slug, int $perPage = 10)
    {
        return $this->model
            ->join('hotels', 'room_types.hotel_id', '=', 'hotels.id')
            ->where('hotels.slug', $slug)
            ->select('room_types.*')
            ->orderByDesc('room_types.created_at')
            ->paginate($perPage);
    }
}
