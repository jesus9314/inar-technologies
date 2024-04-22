<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'symbol'
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
