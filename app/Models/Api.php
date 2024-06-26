<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'documentation_link',
        'status',
        'env_name'
    ];
}
