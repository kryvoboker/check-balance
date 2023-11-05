<?php

namespace App\Models\User;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\User\UserLogin
 *
 * @property int $id
 * @property string $ip_address
 * @property string $email
 * @property int $number_of_tries
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserLogin newModelQuery()
 * @method static Builder|UserLogin newQuery()
 * @method static Builder|UserLogin query()
 * @method static Builder|UserLogin whereCreatedAt($value)
 * @method static Builder|UserLogin whereEmail($value)
 * @method static Builder|UserLogin whereId($value)
 * @method static Builder|UserLogin whereIpAddress($value)
 * @method static Builder|UserLogin whereNumberOfTries($value)
 * @method static Builder|UserLogin whereUpdatedAt($value)
 * @mixin Eloquent
 */
class UserLogin extends Model
{
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'number_of_tries' => 'int'
    ];

    protected $fillable = [
        'ip_address',
        'email',
        'number_of_tries'
    ];
}
