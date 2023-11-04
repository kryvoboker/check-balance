<?php

namespace App\Http\Requests;

use App\Models\User;
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
        if (!filter_var($this->input('email'), FILTER_VALIDATE_EMAIL)) {
            $this->session()->flash('errors', __('user/login.error_email'));

            return true;
        }

        $user_info = User::takeUserInfo($this->input('email'));

        $auth_info = $this->authorizationService->canAuthenticate($user_info);

        /*if ($auth_info['can_auth']) { //TODO: modify it for user_login table
            User::clearTryAuth($this->input('email'));

            return true;
        }

        if (isset($auth_info['error_user_failed_tries_auth'])) {
            $this->session()->flash('errors', $auth_info['error_user_failed_tries_auth']);

            Cookie::queue('user_failed_tries_auth', true, 60 * 3);
        } else {
            $this->session()->flash('errors', $auth_info['error']);
        }*/

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string[]", 'password' => "string[]"])]
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
    public function messages(): array
    {
        return [
            'email.required' => __('user/validation.error_email'),
            'password.required' => __('user/validation.error_password'),
        ];
    }
}
