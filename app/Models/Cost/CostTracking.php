<?php

namespace App\Models\Cost;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cost\CostTracking
 *
 * @property int $id
 * @property int $user_id
 * @property float $money_earned
 * @property int $start_month_day
 * @property int $next_month_day
 * @property string $costs
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Dream> $dreams
 * @property-read int|null $dreams_count
 * @property-read User $user
 * @method static Builder|CostTracking newModelQuery()
 * @method static Builder|CostTracking newQuery()
 * @method static Builder|CostTracking query()
 * @method static Builder|CostTracking whereCosts($value)
 * @method static Builder|CostTracking whereCreatedAt($value)
 * @method static Builder|CostTracking whereCurrentMonthDay($value)
 * @method static Builder|CostTracking whereId($value)
 * @method static Builder|CostTracking whereMoneyEarned($value)
 * @method static Builder|CostTracking whereNextMonthDay($value)
 * @method static Builder|CostTracking whereUpdatedAt($value)
 * @method static Builder|CostTracking whereUserId($value)
 * @mixin Eloquent
 */
class CostTracking extends Model
{
    protected $fillable = [
        'user_id',
        'money_earned',
        'start_month_day',
        'next_month_day',
        'costs',
    ];

    protected $casts = [
        'money_earned' => 'float'
    ];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function dreams() : HasMany
    {
        return $this->hasMany(Dream::class);
    }

    /**
     * @return Attribute
     */
    protected function currentMonthDay() : Attribute
    {
        return Attribute::make(
            set : fn(int $start_month_day) => date('Y-m') . '-' . $start_month_day
        );
    }

    /**
     * @return Attribute
     */
    protected function nextMonthDay() : Attribute
    {
        return Attribute::make(
            set : fn(int $next_month_day) => date('Y-m', strtotime('+1 month')) . '-' . $next_month_day
        );
    }

    /**
     * @return Attribute
     */
    protected function costs() : Attribute
    {
        return Attribute::make(
            get : fn(string $json_costs) => json_decode($json_costs, true),
            set : fn(?array $costs) => json_encode(($costs ?? []))
        );
    }
}
