<?php

namespace App\Http\Requests\Cost;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCostTrackingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
