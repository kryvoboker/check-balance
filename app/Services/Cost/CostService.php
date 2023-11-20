<?php

namespace App\Services\Cost;

use App\Models\Cost\CostTracking;
use Carbon\CarbonImmutable;
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
        $data['start_month_day'] = (int)$days[0];
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

        $current_date = CarbonImmutable::now(config('app.timezone'));

        $parsed_start_date = Carbon::parse($cost_info->start_month_day);
        $parsed_end_date = Carbon::parse($cost_info->next_month_day);

        $data->put('end_date', $cost_info->next_month_day);
        $data->put('start_date', $cost_info->start_month_day);

        $this->processLimitMoneysOnEachDay($parsed_start_date, $parsed_end_date, $current_date, $data, $cost_info->money_earned); // TODO: dev it
        $this->processDatePeriod($parsed_start_date, $parsed_end_date, $current_date, $data);

        return $data;
    }

    /**
     * @param Carbon $parsed_start_date
     * @param Carbon $parsed_end_date
     * @param CarbonImmutable $current_date
     * @param Collection $dates
     * @return void
     */
    private function processLimitMoneysOnEachDay(Carbon $parsed_start_date, Carbon $parsed_end_date, CarbonImmutable $current_date, Collection &$data, float $money_earned) : void
    {
        $dates = [];

        $start_month_number = (int)$parsed_start_date->format('m');

        $days_from_db_for_start_month = $parsed_start_date->daysInMonth;
        $days_from_db_for_next_month = (int)$parsed_end_date->format('d');

        $count_days = 0;

        $days_from_current_period = $this->takeDaysFromCurrentPeriod($current_date, $start_month_number, $days_from_db_for_start_month, $days_from_db_for_next_month);


        if ($current_date->month != $start_month_number) {
            $days_in_current_month = ($days_from_db_for_start_month - $current_date->day);

            for ($day_index = 0; $day_index <= $days_in_current_month; $day_index++) {
                $dates[$count_days] = $count_days;

                $count_days++;
            }

            $count_days--;
        }

        for ($day_index = 0; $day_index <= $days_from_db_for_next_month; $day_index++) {
            $dates[$count_days] = $count_days;

            $count_days++;
        }


    }

    /**
     * @param Carbon $parsed_start_date
     * @param Carbon $parsed_end_date
     * @param CarbonImmutable $current_date
     * @param Collection $data
     */
    private function processDatePeriod(Carbon $parsed_start_date, Carbon $parsed_end_date, CarbonImmutable $current_date, Collection &$data) : void
    {
        $dates = [];

        $days_from_db_for_start_month = $parsed_start_date->daysInMonth;
        $start_day = (int)$parsed_start_date->format('d');
        $days_from_db_for_next_month = (int)$parsed_end_date->format('d');

        $count_days = 0;

        $days_in_current_month = ($days_from_db_for_start_month - $start_day);

        for ($day_index = 0; $day_index <= $days_in_current_month; $day_index++) {
            $dates[$count_days] = $current_date->add($count_days, 'days')->toDateString();

            $count_days++;
        }

        $count_days--;

        for ($day_index = 0; $day_index <= $days_from_db_for_next_month; $day_index++) {
            $dates[$count_days] = $current_date->add($count_days, 'days')->toDateString();

            $count_days++;
        }

        $data->put('dates', $dates);
    }

    /**
     * @param CarbonImmutable $current_date
     * @param int $start_month_number
     * @param int $days_from_db_for_start_month
     * @param int $days_from_db_for_next_month
     * @return array
     */
    private function takeDaysFromCurrentPeriod(CarbonImmutable $current_date, int $start_month_number, int $days_from_db_for_start_month, int $days_from_db_for_next_month) : int
    {
        $dates = [];
        $count_days = 0;

        if ($current_date->month != $start_month_number) {
            $days_in_current_month = ($days_from_db_for_start_month - $current_date->day);

            for ($day_index = 0; $day_index <= $days_in_current_month; $day_index++) {
                $dates[$count_days] = $count_days;

                $count_days++;
            }

            $count_days--;
        }

        for ($day_index = 0; $day_index <= $days_from_db_for_next_month; $day_index++) {
            $dates[$count_days] = $count_days;

            $count_days++;
        }

        return count($dates);
    }
}
