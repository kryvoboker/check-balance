<?php

namespace App\Models\Cost;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Cost\CostTracking
 *
 * @property int $id
 * @property int $user_id
 * @property float $money_earned
 * @property int $current_month_day
 * @property int $next_month_day
 * @property string $costs
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cost\Dream> $dreams
 * @property-read int|null $dreams_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking query()
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereCosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereCurrentMonthDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereMoneyEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereNextMonthDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostTracking whereUserId($value)
 * @mixin \Eloquent
 */
class CostTracking extends Model
{
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dreams() : HasMany
    {
        return $this->hasMany(Dream::class);
    }
}
