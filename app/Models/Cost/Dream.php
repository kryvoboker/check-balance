<?php

namespace App\Models\Cost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dream extends Model
{
    public function costTracking() : BelongsTo
    {
        return $this->belongsTo(CostTracking::class);
    }
}
