<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class State extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'description',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function currencies(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
