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

        $costs = $cost_tracking->costs;
        $money_earned = $cost_tracking->money_earned;

        $parsed_start_date = CarbonImmutable::parse($cost_tracking->start_month_day);
        $parsed_end_date = CarbonImmutable::parse($cost_tracking->next_month_day);

        $data->put('end_date', $cost_tracking->next_month_day);
        $data->put('start_date', $cost_tracking->start_month_day);

//        $this->processLimitMoneysOnEachDay($parsed_start_date, $parsed_end_date, $current_date, $data, $cost_info->money_earned); // TODO: dev it
        $this->processDatePeriod($parsed_start_date, $parsed_end_date, $data, $money_earned, $costs);

        return $data;
    }

    /**
     * @param CarbonImmutable $parsed_start_date
     * @param CarbonImmutable $parsed_end_date
     * @param Collection $data
     * @param float|int $money_earned
     * @param array $costs
     */
    private function processDatePeriod(CarbonImmutable $parsed_start_date, CarbonImmutable $parsed_end_date, Collection $data, float|int $money_earned, array $costs) : void
    {
        $dates = $this->createArrayDates($parsed_start_date, $parsed_end_date);

        $total_days = count($dates);

        $data->put('money_limit_per_day', round($money_earned / $total_days, 2) . ' ' . __('cost/show.text_currency_value'));





        $current_date_obj = CarbonImmutable::now(config('app.timezone'));
        $current_date = $current_date_obj->toDateString();

        $total_days_left = 0;

        foreach ($dates as $date_info) {
            if ($date_info['date'] >= $current_date) {
                $total_days_left++;
            }
        }

        $total_costs_in_month = 0;

        foreach ($costs as $cost_info) {
            if (!isset($cost_info['total'])) {
                continue;
            }

            $total_costs = count($cost_info['total']);

            for ($total_index = 0; $total_index < $total_costs; $total_index++) {
                $total_costs_in_month += (float)$cost_info['total'][$total_index];
            }
        }

        $money_limit_per_left_days = round(($money_earned - $total_costs_in_month) / $total_days_left, 2) . ' ' . __('cost/show.text_currency_value');

        foreach ($dates as &$date_info) {
            if ($date_info['date'] >= $current_date) {
                $date_info['money_limit_per_left_day'] = $money_limit_per_left_days;
            }
        }

        foreach ($dates as &$date_info) {
            foreach ($costs as $cost_date => $cost_info) {
                if ($date_info['date'] == $cost_date && isset($cost_info['name'])) {
                    $total_costs = count($cost_info['name']);

                    for ($name_index = 0; $name_index < $total_costs; $name_index++) {
                        $date_info['costs'][$name_index]['cost_name'] = $cost_info['name'][$name_index];
                        $date_info['costs'][$name_index]['cost_total'] = $cost_info['total'][$name_index];
                    }
                }
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
