<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'description',
        'maintenance_state_id',
        'customer_id',
        'device_id',
        'user_id',
        'customer_requet',
        'recommendations'
    ];

    public function maintenanceState(): BelongsTo
    {
        return $this->belongsTo(MaintenanceState::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function maintenanceIssues()
    {
        return $this->hasMany(MaintenanceIssue::class);
    }

    public function maintenanceProcedures()
    {
        return $this->hasMany(MaintenanceProcedure::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
