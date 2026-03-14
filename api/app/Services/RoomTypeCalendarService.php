<?php

namespace App\Services;

use App\Models\RoomType;
use App\Repositories\RoomTypeCalendarRepository;
use App\Services\PriceService;
use Carbon\Carbon;

class RoomTypeCalendarService extends BaseService
{
    protected $priceService;

    public function __construct(
        RoomTypeCalendarRepository $repository,
        PriceService $priceService
    ) {
        parent::__construct($repository);
        $this->priceService = $priceService;
    }

    /**
     * Generate calendar khi hotel được publish
     * 
     * ví dụ:
     * tạo calendar 60 ngày tiếp theo
     */
    public function generate(RoomType $roomType, $days = 60)
    {
        $today = Carbon::today();

        for ($i = 0; $i < $days; $i++) {

            $date = $today->copy()->addDays($i);

            $price = $this->priceService->calculate($roomType, $date);

            $this->repository->restoreOrCreate(
                $roomType->id,
                $date,
                $price,
                $roomType->total_rooms
            );
        }
    }

    /**
     * Recalculate price theo khoảng ngày
     * 
     * dùng khi:
     * - tạo price rule
     * - update price rule
     */
    public function updatePriceByDateRange(RoomType $roomType, $startDate, $endDate)
    {
        $today = Carbon::today();

        $date = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if ($date->lt($today)) {
            $date = $today;
        }

        while ($date->lte($end)) {

            $price = $this->priceService->calculate($roomType, $date);

            $this->repository->updatePrice(
                $roomType->id,
                $date->toDateString(),
                $price
            );

            $date->addDay();
        }
    }
}
