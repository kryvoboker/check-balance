<?php

namespace App\Services;

use Illuminate\Support\Collection;

class AuthorizationService
{
    /**
     * @param Collection $user
     * @return false[]
     */
    public function canAuthenticate(Collection $user) : array
    {
        $result = [
            'can_auth' => false
        ];

        if ($user->isEmpty()) {
            $result['error'] = __('user/login.error_user_not_exists');

            return $result;
        } else if (!$user->first()->status) {
            $result['error'] = __('user/login.error_access_denied');

            return $result;
        }

        $last_failed_try_auth = $user->first()->last_failed_try_auth;

        if ($user->first()->numbers_failed_try_auth > 3 && strtotime($last_failed_try_auth) > strtotime('-3 hours')) {
            $result['error_user_failed_tries_auth'] = __('user/login.error_user_failed_tries_auth');

            return $result;
        }

        $result['can_auth'] = true;

        return $result;
    }
}
