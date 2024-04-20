<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceState extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function device(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
