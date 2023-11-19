<?php

namespace App\Services\Cost;

use App\Models\Cost\CostTracking;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CostService
{
    /**
     * @return array|Collection
     */
    public function getCostsList() : array|Collection
    {
        $costs = CostTracking::select(['id', 'user_id', 'money_earned', 'current_month_day', 'next_month_day'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')->get();

        return ($costs->isNotEmpty() ? $costs : []);
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
            $data['costs'] = json_encode($request_inputs->get('cost'));
        }

        CostTracking::create($data);

        if ($request_inputs->has('dream')) {
            $this->processDreams($request_inputs->get('dream'));
        }
    }

    private function processDreams(array $dreams_info)
    {

    }
}
