<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessorCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function processors(): HasMany
    {
        return $this->hasMany(Processor::class);
    }
}
