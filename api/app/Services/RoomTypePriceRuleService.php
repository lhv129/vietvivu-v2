<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Repositories\RoomTypePriceRuleRepository;
use App\Services\RoomTypeCalendarService;
use Illuminate\Support\Carbon;

class RoomTypePriceRuleService extends BaseService
{
    protected string $notFoundMessage = "Price rule không tồn tại.";
    protected $roomTypeCalendarService;

    public function __construct(
        RoomTypePriceRuleRepository $repository,
        RoomTypeCalendarService $roomTypeCalendarService
    ) {
        parent::__construct($repository);

        $this->roomTypeCalendarService = $roomTypeCalendarService;
    }

    /**
     * Tạo price rule
     * 
     * sau khi tạo sẽ recalculate calendar
     */
    public function create(array $data)
    {
        $rule = $this->repository->create($data);

        $roomType = $rule->roomType;

        if ($roomType->hotel->status === 'published') {

            $start = $rule->start_date ?? now();
            $end   = $rule->end_date ?? now()->addDays(60);

            $this->roomTypeCalendarService
                ->updatePriceByDateRange($roomType, $start, $end);
        }

        $rule->unsetRelation('roomType');

        return $rule;
    }

    /**
     * Update price rule
     * 
     * sau khi update sẽ recalc lại calendar
     */
    public function update($id, array $data)
    {
        $rule = $this->repository->find($id);

        if (!$rule) {
            throw new ApiException("Rule không tồn tại", 404);
        }

        $oldStart = $rule->start_date ?? now();
        $oldEnd   = $rule->end_date ?? now()->addDays(60);

        $rule->update($data);

        $roomType = $rule->roomType;

        $newStart = $rule->start_date ?? now();
        $newEnd   = $rule->end_date ?? now()->addDays(60);

        $recalcStart = Carbon::parse($oldStart)->min($newStart);
        $recalcEnd   = Carbon::parse($oldEnd)->max($newEnd);

        $this->roomTypeCalendarService
            ->updatePriceByDateRange($roomType, $recalcStart, $recalcEnd);

        return $rule;
    }
}
