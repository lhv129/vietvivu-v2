<?php

namespace App\Services;

use App\Models\RoomType;
use Illuminate\Support\Carbon;


class PriceService
{
    public function calculate(RoomType $roomType, $date)
    {
        $date = Carbon::parse($date);
        $price = $roomType->base_price;

        $rules = $roomType->priceRules()
            ->where('is_active', 1)
            ->get();

        foreach ($rules as $rule) {

            if (!$this->matchDate($rule, $date)) {
                continue;
            }

            // override -> ghi đè giá
            if ($rule->type === 'override') {
                return (int) $rule->amount;
            }

            if ($rule->amount_type === 'percent') {
                $price += $price * ($rule->amount / 100);
            } else {
                $price += $rule->amount;
            }
        }

        return (int) $price;
    }

    private function matchDate($rule, Carbon $date)
    {
        if ($rule->start_date && $date->lt($rule->start_date)) {
            return false;
        }

        if ($rule->end_date && $date->gt($rule->end_date)) {
            return false;
        }

        if ($rule->days_of_week) {

            $days = $rule->days_of_week;

            if (!in_array($date->dayOfWeek, $days)) {
                return false;
            }
        }

        return true;
    }
}
