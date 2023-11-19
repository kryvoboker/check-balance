<?php

namespace App\Services\Cost;

use App\Models\Cost\CostTracking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CostService
{
    /**
     * @return Collection
     */
    public function getCostsList() : Collection
    {
        return CostTracking::select(['id', 'user_id', 'money_earned', 'current_month_day', 'next_month_day'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')->get();
    }

    /**
     * @param Collection $request_inputs
     */
    public function saveCost(Collection $request_inputs) : void
    {
        $data = [];
        $days = explode('-', $request_inputs->get('date_range'));

        $data['user_id'] = Auth::id();
        $data['money_earned'] = (float)$request_inputs->get('income_funds');
        $data['current_month_day'] = (int)$days[0];
        $data['next_month_day'] = (int)$days[1];

        if ($request_inputs->has('cost')) {
            $data['costs'] = $request_inputs->get('cost');
        }

        CostTracking::create($data);

        if ($request_inputs->has('dream')) { //TODO: dev it functionality
            $this->processDreams($request_inputs->get('dream'));
        }
    }

    private function processDreams(array $dreams_info)
    {

    }

    /**
     * @param CostTracking $cost_info
     * @return Collection
     */
    public function processCostInfo(CostTracking $cost_info) : Collection
    {
        $data = collect();
        $dates = [];

        $current_date = Carbon::now();

        $current_days_in_month = $current_date->daysInMonth;

        $days_from_db_for_start_month = (int)Carbon::parse($cost_info->current_month_day)->format('d');
        $days_from_db_for_next_month = (int)Carbon::parse($cost_info->next_month_day)->format('d');

        for ($day_index = $days_from_db_for_start_month; $day_index <= $current_days_in_month; $day_index++) {
            $dates[$day_index] = clone $current_date->startOfMonth()->addDays($day_index - 1);
        }

        for ($day_index = 1; $day_index <= $days_from_db_for_next_month; $day_index++) {
            $dates[$day_index] = clone $current_date->startOfMonth()->addMonth()->addDays($day_index - 1);
        }

        $data->put('dates', $dates);

        return $data;
    }
}
