<?php

namespace App\Models;

use App\Observers\OperatingSystemObserver;
use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(OperatingSystemObserver::class)]
class OperatingSystem extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'description',
        'image_url'
    ];
}
