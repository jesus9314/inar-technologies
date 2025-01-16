<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'maintenance_id'
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
}
