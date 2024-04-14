<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'comercial_name',
        'document_number',
        'phone_number',
        'image_url',
        'web',
        'address',
        'email',
        'id_document_id',
        'supplier_type_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(IdDocument::class);
    }

    public function supplierType(): BelongsTo
    {
        return $this->belongsTo(SupplierType::class);
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function countries() : BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }
}
