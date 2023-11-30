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
        return CostTracking::select(['id', 'user_id', 'money_earned', 'start_month_day', 'next_month_day'])
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

        $parsed_start_date = CarbonImmutable::parse(date('Y-m') . '-' . (int)$days[0]);
        $parsed_end_date = CarbonImmutable::parse(date('Y-m') . '-' . (int)$days[1]);

        $data['costs'] = $this->createArrayDates($parsed_start_date, $parsed_end_date);

        CostTracking::create($data);

        if ($request_inputs->has('dream')) { //TODO: dev it functionality
            $this->processDreams($request_inputs->get('dream'));
        }
    }

    private function processDreams(array $dreams_info)
    {

    }

    /**
     * @param CostTracking $cost_tracking
     * @param Collection $request_inputs
     * @return void
     */
    public function updateCost(CostTracking $cost_tracking, Collection $request_inputs) : void
    {
//        $cost_tracking->money_earned = $request_inputs->get('money_earned'); // TODO: need will to add the money earned input field for change it
        $cost_tracking->costs = $request_inputs->get('cost');

        $cost_tracking->save();

        /*if ($request_inputs->has('dream')) { // TODO: need to dev the functional for update dreams table

        }*/
    }

    /**
     * @param CostTracking $cost_tracking
     * @return Collection
     */
    public function processCostInfo(CostTracking $cost_tracking) : Collection
    {
        $data = collect();

        $current_date = CarbonImmutable::now(config('app.timezone'));

        $parsed_start_date = CarbonImmutable::parse($cost_tracking->start_month_day);
        $parsed_end_date = CarbonImmutable::parse($cost_tracking->next_month_day);

        $data->put('end_date', $cost_tracking->next_month_day);
        $data->put('start_date', $cost_tracking->start_month_day);

//        $this->processLimitMoneysOnEachDay($parsed_start_date, $parsed_end_date, $current_date, $data, $cost_info->money_earned); // TODO: dev it
        $this->processDatePeriod($parsed_start_date, $parsed_end_date, $data, $cost_tracking->money_earned);

        return $data;
    }

    /**
     * @param Carbon $parsed_start_date
     * @param Carbon $parsed_end_date
     * @param CarbonImmutable $current_date
     * @param Collection $data
     * @param float $money_earned
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
     * @param CarbonImmutable $parsed_start_date
     * @param CarbonImmutable $parsed_end_date
     * @param Collection $data
     * @param float|int $money_earned
     */
    private function processDatePeriod(CarbonImmutable $parsed_start_date, CarbonImmutable $parsed_end_date, Collection $data, float|int $money_earned) : void
    {
        $dates = $this->createArrayDates($parsed_start_date, $parsed_end_date);

        $total_days = count($dates);

        $data->put('money_limit_per_day', round($money_earned / $total_days, 2) . ' ' . __('cost/show.text_currency_value'));





        $current_date_obj = CarbonImmutable::now(config('app.timezone'));
        $current_date = $current_date_obj->toDateString();

        $total_days_left = 0;

        foreach ($dates as $date) {
            if ($date['date'] >= $current_date) {
                $total_days_left++;
            }
        }

        // TODO: need to calc $money_earned - total_costs
        $money_limit_per_left_days = round($money_earned / $total_days_left, 2) . ' ' . __('cost/show.text_currency_value');

        foreach ($dates as &$date) {
            if ($date['date'] >= $current_date) {
                $date['money_limit_per_left_day'] = $money_limit_per_left_days;
            }
        }

        $data->put('dates', $dates);
    }

    /**
     * @param CarbonImmutable $current_date
     * @param int $start_month_number
     * @param int $days_from_db_for_start_month
     * @param int $days_from_db_for_next_month
     * @return int
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

    /**
     * @param CarbonImmutable $parsed_start_date
     * @param CarbonImmutable $parsed_end_date
     * @return array
     */
    private function createArrayDates(CarbonImmutable $parsed_start_date, CarbonImmutable $parsed_end_date) : array
    {
        $dates = [];

        $days_from_db_for_start_month = $parsed_start_date->daysInMonth;
        $start_day = (int)$parsed_start_date->format('d');
        $days_from_db_for_next_month = (int)$parsed_end_date->format('d');

        $count_days = 0;

        $left_days_in_start_month = ($days_from_db_for_start_month - $start_day);

        for ($day_index = 0; $day_index <= $left_days_in_start_month; $day_index++) {
            $need_date = $parsed_start_date->add($count_days, 'days')->toDateString();

            $dates[$need_date]['date'] = $need_date;

            $count_days++;
        }

        $count_days--;

        for ($day_index = 0; $day_index <= $days_from_db_for_next_month; $day_index++) {
            $need_date = $parsed_start_date->add($count_days, 'days')->toDateString();

            $dates[$need_date]['date'] = $need_date;

            $count_days++;
        }

        return $dates;
    }
}
