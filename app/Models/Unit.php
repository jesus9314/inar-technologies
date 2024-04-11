<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    use HasFactory;

    protected $fillable= [
        'code',
        'description',
        'symbol',
        'activity_state_id',
    ];

    public function ActivityState(): BelongsTo
    {
        return $this->belongsTo(ActivityState::class);
    }
}
