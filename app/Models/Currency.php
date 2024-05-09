<?php

namespace App\Models;

use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'code',
        'description',
        'symbol',
        'activity_state_id'
    ];

    public function ActivityState(): BelongsTo
    {
        return $this->belongsTo(ActivityState::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
