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
            'date_range' => ['required', 'regex:/\d+-\d+/'],
            'income_funds' => ['required', 'numeric'],
            'cost' => [new ValidateAddCost],
            'dream' => [new ValidateAddDream],
        ];
    }

    /**
     * @return array
     */
    public function messages() : array
    {
        return [
            'date_range.required' => __('cost/create.error_date_range'),
            'date_range.regex' => __('cost/create.error_date_range_regex'),
            'income_funds.required' => __('cost/create.error_income_funds'),
            'income_funds.numeric' => __('cost/create.error_income_funds_numeric'),
        ];
    }

    protected function prepareForValidation() : void
    {
        $this->merge([
            'date_range' => trim($this->input('date_range')),
            'income_funds' => trim($this->input('income_funds')),
        ]);
    }
}
