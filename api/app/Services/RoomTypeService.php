<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Helpers\ImageHelper;
use App\Repositories\RoomTypeRepository;
use App\Services\RoomTypeCalendarService;
use Illuminate\Support\Facades\DB;

class RoomTypeService extends BaseService
{
    protected string $notFoundMessage = "Loại phòng không tồn tại.";
    protected $roomTypeCalendarService;

    public function __construct(
        RoomTypeRepository $repository,

        RoomTypeCalendarService $roomTypeCalendarService
    ) {
        parent::__construct($repository);
        $this->roomTypeCalendarService = $roomTypeCalendarService;
    }

    // Lấy danh sách loại phòng (room-types) theo hotel
    public function getByHotelSlug(string $slug, int $perPage = 10)
    {
        return $this->repository->getByHotelSlug($slug, $perPage);
    }


    /**
     * Tạo room type
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $featuredImage = $data['featured_image'] ?? null;
            $data['featured_image'] = '';

            $roomType = $this->repository->create($data);

            if ($featuredImage) {

                $path = ImageHelper::uploadSingle(
                    $featuredImage,
                    "hotels/{$roomType->hotel_id}/room-types/{$roomType->id}"
                );

                $this->repository->update($roomType, [
                    'featured_image' => $path
                ]);
            }

            $roomType->load('hotel');

            if ($roomType->hotel->status === 'published') {
                $this->roomTypeCalendarService->generate($roomType);
            }

            $roomType->unsetRelation('hotel');

            return $roomType;
        });
    }

    /**
     * Update room type
     */
    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $roomType = $this->repository->find($id);

            if (!$roomType) {
                throw new ApiException($this->notFoundMessage, 404);
            }

            /**
             * Upload featured image nếu có
             */
            if (isset($data['featured_image'])) {

                $data['featured_image'] = ImageHelper::uploadSingle(
                    $data['featured_image'],
                    "hotels/{$roomType->hotel_id}/room-types/{$roomType->id}",
                    $roomType->featured_image
                );
            }

            /**
             * Xử lý update total_rooms
             */
            if (isset($data['total_rooms'])) {

                $oldTotal = $roomType->total_rooms;
                $newTotal = $data['total_rooms'];

                /**
                 * Lấy calendar của room type
                 */
                $calendars = DB::table('room_type_calendars')
                    ->where('room_type_id', $roomType->id)
                    ->lockForUpdate()
                    ->get();

                foreach ($calendars as $calendar) {

                    $bookedRooms = $oldTotal - $calendar->available_rooms;

                    /**
                     * Nếu giảm phòng mà nhỏ hơn số đã book → lỗi
                     */
                    if ($newTotal < $bookedRooms) {
                        throw new ApiException(
                            "Không thể giảm số phòng nhỏ hơn số phòng đã được đặt ({$bookedRooms})",
                            400
                        );
                    }

                    $newAvailable = $newTotal - $bookedRooms;

                    DB::table('room_type_calendars')
                        ->where('id', $calendar->id)
                        ->update([
                            'available_rooms' => $newAvailable
                        ]);
                }
            }

            $oldBasePrice = $roomType->base_price;

            /**
             * Update room type
             */
            $roomType = $this->repository->update($roomType, $data);

            /**
             * Nếu base_price thay đổi → recalc calendar
             */
            if (isset($data['base_price']) && $data['base_price'] != $oldBasePrice) {

                $start = now();
                $end   = now()->addDays(60);

                $this->roomTypeCalendarService
                    ->updatePriceByDateRange($roomType, $start, $end);
            }

            /**
             * Update room type
             */
            return $roomType;
        });
    }

    /**
     * Xóa room type
     */
    public function delete($id)
    {
        return DB::transaction(function () use ($id) {

            $roomType = $this->repository->find($id);

            if (!$roomType) {
                throw new ApiException($this->notFoundMessage, 404);
            }

            ImageHelper::deleteDirectory(
                "uploads/hotels/{$roomType->hotel_id}/room-types/{$roomType->id}"
            );

            return $this->repository->delete($roomType);
        });
    }
}
