<?php

namespace App\Http\Requests;

use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cookie;

class LoginRequest extends FormRequest
{
    private array $error;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        if (!filter_var($this->input('email'), FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $auth_info = User::takeAuthInfo($this->input('email'));

        if ($auth_info['can_auth']) {
            return true;
        }

        if (isset($auth_info['error_user_failed_tries_auth'])) {
            $this->error['error_user_failed_tries_auth'] = $auth_info['error_user_failed_tries_auth'];

            Cookie::queue('error_user_failed_tries_auth', true, 60 * 3);
        } else {
            $this->error['other_errors'] = [$auth_info['error']];
        }

        return false;
    }

    /**
     * @throws AuthException
     */
    protected function failedAuthorization() : void
    {
        throw new AuthException($this->error);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required', 'min:3', 'max:255'],
        ];
    }
}
