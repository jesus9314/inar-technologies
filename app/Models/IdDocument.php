<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class IdDocument extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'description',
        'state_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function ActivityState(): BelongsTo
    {
        return $this->belongsTo(ActivityState::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function costumers(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
