<?php

namespace App\Models;

use App\Enums\ColorsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuePriority extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'color' => ColorsEnums::class
        ];
    }
}
