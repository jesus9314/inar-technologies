<?php

namespace App\Models;

use App\Traits\HasLogActivities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamFormFactor extends Model
{
    use HasFactory, HasLogActivities;

    protected $fillable = [
        'description'
    ];

    public function rams()
    {
        return $this->hasMany(Ram::class);
    }
}
