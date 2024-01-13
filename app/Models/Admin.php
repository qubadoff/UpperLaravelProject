<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->getAttribute('name') . ' ' . $this->getAttribute('surname'),
        );
    }
}
