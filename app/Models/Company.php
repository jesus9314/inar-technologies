<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use TomatoPHP\FilamentLocations\Models\Country;

class Company extends Model
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var array
     */
    protected $fillable = ['country_id', 'name', 'ceo', 'address', 'city', 'zip', 'registration_number', 'tax_number', 'email', 'phone', 'website', 'notes', 'created_at', 'updated_at'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
