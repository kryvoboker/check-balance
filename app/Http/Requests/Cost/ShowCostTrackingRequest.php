<?php

namespace App\Http\Requests\Cost;

use App\Models\Cost\CostTracking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowCostTrackingRequest extends FormRequest
{
    private CostTracking $cost_tracking;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param CostTracking $cost_tracking
     * @return bool
     */
    public function authorize(CostTracking $cost_tracking) : bool
    {
        $this->cost_tracking = $cost_tracking->get()->first();

        return $this->cost_tracking->user_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array>
     */
    public function rules() : array
    {
        return [
            //
        ];
    }

    /**
     * @return CostTracking
     */
    public function getCostTracking() : CostTracking
    {
        return $this->cost_tracking;
    }
}
