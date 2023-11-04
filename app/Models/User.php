<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * @return Collection
     */
    public static function takeUserInfo(string $email) : Collection
    {
        return DB::table('users')
            ->select('numbers_failed_try_auth', 'status')
            ->where('email', '=', $email)
            ->get();
    }

    /**
     * @param string $email
     */
    public static function clearTryAuth(string $email) : void //TODO: rebuild this logic using user_login table
    {
        DB::table('users')->where('email', '=', $email)
            ->update([
                'numbers_failed_try_auth' => 0,
                'last_failed_try_auth' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Interact with the user's first name.
     * Check this mutator for telephone - https://laravel.com/docs/10.x/eloquent-mutators#defining-a-mutator
     */
    protected function telephone(): Attribute
    {
        return Attribute::make(
            get: fn (string $telephone) => $this->parseTelephone($telephone),
            set: fn (string $telephone) => preg_replace(['/^\+38/', '/\D+/'], '', $telephone),
        );
    }

    /**
     * @param string $telephone
     * @return string
     */
    private function parseTelephone(string $telephone) : string
    {
        $mask = '+38 (___) ___-__-__';
        $phone_length = mb_strlen($telephone, 'UTF-8');

        for ($index_number = 0; $index_number < $phone_length; $index_number++) {
            $mask = preg_replace('/_/', $telephone[$index_number], $mask, 1);
        }

        return $mask;
    }
}
