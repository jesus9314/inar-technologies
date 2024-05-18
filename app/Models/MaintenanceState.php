<?php

namespace App\Models;

use App\Enums\ColorEnum;
use App\Enums\ColorsEnums;
use App\Enums\IssuePriortyColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceState extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
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
            'color' => ColorEnum::class,
        ];
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}
