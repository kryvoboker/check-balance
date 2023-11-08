<?php

namespace App\Services;

use App\Models\User;
use App\Models\User\UserLogin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AuthorizationService
{
    /**
     * @param string $email
     * @param $password
     * @param string $ip_address
     * @return void
     */
    public function canAuthenticate(string $email, $password, string $ip_address) : void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            session()->flash('errors', __('user/login.error_email'));

            return;
        }

        $user_login = $this->executeCheckBadUser($ip_address);

        $this->executeValidateUser($email, $password, $user_login, $ip_address);
    }

    /**
     * @param string $ip_address
     * @param Collection $user_login
     */
    private function updateFailTry(string $ip_address, Collection $user_login) : void
    {
        UserLogin::where('ip_address', $ip_address)
            ->orderByDesc('updated_at')
            ->limit(1)
            ->update(['number_of_tries' => ($user_login->first()->number_of_tries + 1)]);
    }

    /**
     * @param Collection $user_login
     * @param string $ip_address
     * @param string $email
     */
    private function updateOrCreateBadUser(Collection $user_login, string $ip_address, string $email) : void
    {
        if ($user_login->isNotEmpty()) {
            $this->updateFailTry($ip_address, $user_login);
        } else {
            UserLogin::create([
                'ip_address' => $ip_address,
                'email' => $email,
                'number_of_tries' => 1,
            ]);
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @param Collection $user_login
     * @param string $ip_address
     */
    private function executeValidateUser(string $email, string $password, Collection $user_login, string $ip_address) : void
    {
        $user = User::select(['status', 'password'])
            ->where('email', $email)
            ->get();

        if ($user->isNotEmpty() && !(Hash::check($password, $user->first()->password))) {
            $this->updateOrCreateBadUser($user_login, $ip_address, $email);

            session()->flash('errors', __('user/login.error_user_not_exists'));

            return;
        }

        if ($user->isEmpty()) {
            $this->updateOrCreateBadUser($user_login, $ip_address, $email);

            session()->flash('errors', __('user/login.error_user_not_exists'));
        } else if (!$user->first()->status) {
            session()->flash('errors', __('user/login.error_access_denied'));
        } else if ($user->first()->status) {
            UserLogin::where('ip_address', $ip_address)
                ->orderByDesc('updated_at')
                ->limit(1)
                ->delete();
        }
    }

    /**
     * @param string $ip_address
     * @return Collection
     */
    private function executeCheckBadUser(string $ip_address) : Collection
    {
        $user_login = UserLogin::where('ip_address', $ip_address)
            ->orderByDesc('updated_at')
            ->limit(1)
            ->get();

        $number_of_tries = (int)($user_login->first()->number_of_tries ?? 0);

        if ($number_of_tries >= 3 && strtotime($user_login->first()->updated_at) > strtotime('-3 hour')) {
            $this->updateFailTry($ip_address, $user_login);

            abort(403, __('user/login.error_user_failed_tries_auth'));
        }

        return $user_login;
    }
}
