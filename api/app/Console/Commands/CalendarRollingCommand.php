<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\RoomType;
use App\Services\PriceService;
use App\Repositories\RoomTypeCalendarRepository;

class CalendarRollingCommand extends Command
{
    protected $signature = 'calendar:rolling';

    protected $description = 'Duy trì lịch phòng trong 60 ngày tới';

    protected $calendarRepo;
    protected $priceService;

    public function __construct(
        RoomTypeCalendarRepository $calendarRepo,
        PriceService $priceService
    ) {
        parent::__construct();

        $this->calendarRepo = $calendarRepo;
        $this->priceService = $priceService;
    }

    public function handle()
    {
        $today = Carbon::today();

        $deleteDate = $today->copy()->subDay();

        $endDate = $today->copy()->addDays(60);

        /**
         * Xóa lịch của ngày hôm qua
         */
        $this->calendarRepo->deleteByDate($deleteDate);

        RoomType::where('is_active', 1)
            ->chunk(100, function ($roomTypes) use ($today, $endDate) {

                foreach ($roomTypes as $roomType) {

                    $existingDates = $this->calendarRepo->getDatesByRoomType(
                        $roomType->id,
                        $today,
                        $endDate
                    );

                    $date = $today->copy();

                    while ($date->lte($endDate)) {

                        $dateString = $date->toDateString();

                        if (!in_array($dateString, $existingDates)) {

                            $price = $this->priceService->calculate(
                                $roomType,
                                $date
                            );

                            $this->calendarRepo->restoreOrCreate(
                                $roomType->id,
                                $date,
                                $price,
                                $roomType->total_rooms
                            );
                        }

                        $date->addDay();
                    }
                }
            });

        $this->info('Đã cập nhật lịch phòng thành công.');
    }
}
