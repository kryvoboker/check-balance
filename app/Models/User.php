<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'telephone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
        'last_failed_try_auth' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @param string $email
     * @return false[]
     */
    public static function takeAuthInfo(string $email) : array
    {
        $user_info = DB::table('users')
            ->select('numbers_failed_try_auth', 'last_failed_try_auth', 'status')
            ->where('email', '=', $email)
            ->get();

        return self::checkCanAuth($user_info, $email);
    }

    /**
     * @param Collection $user
     * @param string $email
     * @return false[]
     */
    private static function checkCanAuth(Collection $user, string $email) : array
    {
        $result = [
            'can_auth' => false
        ];

        if ($user->isEmpty()) {
            $result['error'] = __('login/login.error_user_not_exists');

            return $result;
        } else if (!$user->first()->status) {
            $result['error'] = __('login/login.error_access_denied');

            return $result;
        }

        $last_failed_try_auth = $user->first()->last_failed_try_auth;

        if ($user->first()->numbers_failed_try_auth > 3 && strtotime($last_failed_try_auth) > strtotime('-3 hours')) {
            $result['error_user_failed_tries_auth'] = __('login/login.error_user_failed_tries_auth');

            return $result;
        } else if (strtotime($last_failed_try_auth) < strtotime('-3 hours')) {
            self::clearTryAuth($email);
        }

        $result['can_auth'] = true;

        return $result;
    }

    /**
     * @param string $email
     */
    private static function clearTryAuth(string $email) : void
    {
        DB::table('users')->where('email', '=', $email)
            ->update([
                'numbers_failed_try_auth' => 0,
                'last_failed_try_auth' => date('Y-m-d H:i:s'),
            ]);
    }
}
