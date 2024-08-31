<?php

namespace App\Models;

use App\Observers\CustomerObserver;
use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy(CustomerObserver::class)]
class Customer extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'name',
        'last_name_m',
        'last_name_p',
        'document_number',
        'user_id',
        'id_document_id'
    ];

    protected $appends = ['display_name'];

    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->document_number})";
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class);
    }

    public function customerDevice(): HasMany
    {
        return $this->hasMany(CustomerDevice::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function idDocument(): BelongsTo
    {
        return $this->belongsTo(IdDocument::class);
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }
}
