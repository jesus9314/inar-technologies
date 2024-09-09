<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use TomatoPHP\FilamentLocations\Models\Location;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles , LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name_m',
        'last_name_p',
        'document_number',
        'email',
        'password',
        'avatar_url',
        'theme',
        'theme_color',
        'id_document_id',
        'customer_id',
        'id_document_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // dd($this->hasRole(['super_admin']));
        return $this->hasRole(['super_admin']) || $this->hasRole(['supervisor']) ? true : false;
        // return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ?  Storage::url($this->avatar_url) : null;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    public function getAvatarUrl()
    {
        return filament()->getUserAvatarUrl($this);
    }

    // public static function getPermissionPrefixes(): array
    // {
    //     return [
    //         'view',
    //         'view_any',
    //         'create',
    //         'update',
    //         'restore',
    //         'restore_any',
    //         'replicate',
    //         'reorder',
    //         'delete',
    //         'delete_any',
    //         'force_delete',
    //         'force_delete_any',
    //         'assign'
    //     ];
    // }

    public function idDocument(): BelongsTo
    {
        return $this->belongsTo(IdDocument::class);
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}
