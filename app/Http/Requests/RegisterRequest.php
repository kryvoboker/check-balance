<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string[]",
        'lastname' => "string[]",
        'email' => "string[]",
        'telephone' => "string[]",
        'password' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'lastname' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'telephone' => ['required', 'regex:/^\D*(\d\D*){10,12}$/'],
            'password' => ['required', 'min:3', 'max:255', 'confirmed'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    #[ArrayShape([
        'email.required' => "mixed",
        'password.required' => "mixed",
        'confirmed' => "mixed"
    ])]
    public function messages(): array
    {
        return [
            'email.required' => __('user/validation.error_email'),
            'password.required' => __('user/validation.error_password'),
            'confirmed' => __('user/validation.error_password_confirmation'),
        ];
    }
}
