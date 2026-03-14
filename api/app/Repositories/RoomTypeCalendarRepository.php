<?php

namespace App\Repositories;

use App\Models\RoomTypeCalendar;
use Illuminate\Support\Carbon;

class RoomTypeCalendarRepository extends BaseRepository
{
    public function __construct(RoomTypeCalendar $model)
    {
        parent::__construct($model);
    }

    /**
     * Lấy danh sách calendar của room type trong khoảng ngày
     * 
     * Dùng khi:
     * - check availability khi booking
     * - hiển thị calendar phòng
     */
    public function getByDateRange($roomTypeId, $start, $end)
    {
        return $this->model
            ->where('room_type_id', $roomTypeId)
            ->whereBetween('date', [$start, $end])
            ->get();
    }

    /**
     * Update giá của room type trong 1 ngày cụ thể
     * 
     * Dùng khi:
     * - price rule thay đổi
     * - recalculate price
     */
    public function updatePrice($roomTypeId, $date, $price)
    {
        return $this->model
            ->where('room_type_id', $roomTypeId)
            ->whereDate('date', $date)
            ->update([
                'price' => $price
            ]);
    }

    /**
     * Xóa calendar theo ngày
     * 
     * Dùng trong cronjob rolling calendar
     * ví dụ:
     * mỗi ngày xóa lịch của hôm qua
     */
    public function deleteByDate($date)
    {
        return $this->model
            ->whereDate('date', $date)
            ->delete();
    }

    /**
     * Lấy danh sách các ngày đã tồn tại của room type
     * 
     * Dùng để:
     * - kiểm tra ngày đã tồn tại
     * - tránh tạo trùng calendar
     */
    public function getDatesByRoomType($roomTypeId, $start, $end)
    {
        return $this->model
            ->where('room_type_id', $roomTypeId)
            ->whereBetween('date', [$start, $end])
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();
    }

    /**
     * Restore hoặc create calendar
     * 
     * Logic:
     * - nếu tồn tại nhưng soft delete → restore
     * - nếu tồn tại → update
     * - nếu chưa tồn tại → create
     */
    public function restoreOrCreate($roomTypeId, $date, $price, $rooms)
    {
        $calendar = $this->model
            ->withTrashed()
            ->where('room_type_id', $roomTypeId)
            ->whereDate('date', $date)
            ->first();

        if ($calendar) {

            if ($calendar->deleted_at) {
                $calendar->restore();
            }

            $calendar->update([
                'price' => $price,
                'available_rooms' => $rooms
            ]);

            return $calendar;
        }

        return $this->model->create([
            'room_type_id' => $roomTypeId,
            'date' => $date,
            'price' => $price,
            'available_rooms' => $rooms
        ]);
    }
}
