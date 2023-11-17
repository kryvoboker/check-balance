<?php

namespace App\Http\Requests\Cost;

use App\Rules\Cost\ValidateAddCost;
use App\Rules\Cost\ValidateAddDream;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCostTrackingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array>
     */
    public function rules() : array
    {
        return [
            'date_range' => ['required'], //TODO: add check the "-" separator
            'income_funds' => ['required'], //TODO: add check the float value
            'cost' => ['array', new ValidateAddCost],
            'dream' => ['array', new ValidateAddDream],
        ];
    }
}
