<?php

namespace App\Http\Requests\User;

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
            'email' => ['required', 'max:255', 'email', 'unique:App\Models\User,email'],
            'telephone' => ['required', 'regex:/^\D*(\d\D*){10,12}$/', 'unique:App\Models\User,telephone'],
            'password' => ['required', 'min:3', 'max:255', 'confirmed'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    #[ArrayShape([
        'name' => "string",
        'lastname' => "string",
        'email' => "string",
        'telephone' => "string",
        'password' => "string",
        'confirmed' => "string",
    ])]
    public function messages(): array
    {
        return [
            'name' => __('user/validation_register.error_name'),
            'lastname' => __('user/validation_register.error_lastname'),
            'email' => __('user/validation_register.error_email'),
            'telephone' => __('user/validation_register.error_telephone'),
            'password' => __('user/validation_register.error_password'),
            'confirmed' => __('user/validation_register.error_password_confirmation'),
        ];
    }
}
