<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_url',
        'voucherable_id',
        'voucherable_type'
    ];

    public function voucherable(): MorphTo
    {
        return $this->morphTo();
    }
}
