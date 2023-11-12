<?php

namespace App\Services\Cost;

use App\Models\Cost\CostTracking;
use Illuminate\Support\Collection;

class CostService
{
    /**
     * @return array|Collection
     */
    public function getCostsList() : array|Collection
    {
        $costs_list = [];

        $costs = CostTracking::orderByDesc('created_at')->get();

        if ($costs->isNotEmpty()) {
            $costs_list = $costs;
        }

        return $costs_list;
    }
}
