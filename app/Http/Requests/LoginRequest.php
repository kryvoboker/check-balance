<?php

namespace App\Http\Requests;

use App\Services\AuthorizationService;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends FormRequest
{
    protected AuthorizationService $authorizationService;

    public function __construct(AuthorizationService $authorizationService)
    {
        parent::__construct();

        $this->authorizationService = $authorizationService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        $this->authorizationService->canAuthenticate(
            $this->input('email'),
            $this->input('password'),
            $this->ip());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string[]", 'password' => "string[]", 'status' => 'string[]'])]
    public function rules() : array
    {
        return [
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required', 'min:3', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    #[ArrayShape(['email.required' => "string", 'password.required' => "string"])]
    public function messages() : array
    {
        return [
            'email.required' => __('user/validation.error_email'),
            'password.required' => __('user/validation.error_password'),
        ];
    }
}
