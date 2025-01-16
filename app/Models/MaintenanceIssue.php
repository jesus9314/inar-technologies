<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'issues',
        'solution',
        'maintenance_id',
        'issue_priority_id'
    ];

    public function issuePriority()
    {
        return $this->belongsTo(IssuePriority::class);
    }

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
}
