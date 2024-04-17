<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxDocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'activity_state_id'
    ];

    public function activityState(): BelongsTo
    {
        return $this->belongsTo(ActivityState::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
