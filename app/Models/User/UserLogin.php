<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserLogin extends Model
{
    use HasFactory;

    protected $attributes = [
        'date_modified' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * @param string $email
     */
    public function clearTryAuth(string $email) : void
    {
        DB::table('users_login')->where('email', '=', $email)
            ->delete();
    }
}
