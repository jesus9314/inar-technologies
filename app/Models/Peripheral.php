<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peripheral extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'image_url',
        'brand_id',
        'peripheral_type_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function peripheralType(): BelongsTo
    {
        return $this->belongsTo(PeripheralType::class);
    }
}
