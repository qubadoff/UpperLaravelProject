<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'uid',
        'name',
        'surname',
        'image',
        'birthdate',
        'phone',
        'password',
        'type',
        'fmc_token',
        'percent_count',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->getAttribute('name') . ' ' . $this->getAttribute('surname'),
        );
    }
}
