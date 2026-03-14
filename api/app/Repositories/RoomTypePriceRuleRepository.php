<?php

namespace App\Repositories;

use App\Models\RoomTypePriceRule;

class RoomTypePriceRuleRepository extends BaseRepository
{
    public function __construct(RoomTypePriceRule $model)
    {
        parent::__construct($model);
    }

    /**
     * Lấy danh sách price rule của room type
     * 
     * Ví dụ:
     * - weekend +20%
     * - holiday +30%
     * - promotion -10%
     */
    public function getByRoomType($roomTypeId)
    {
        return $this->model
            ->active()
            ->where('room_type_id', $roomTypeId)
            ->get();
    }
}
