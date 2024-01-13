<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketImage extends Model
{
    protected $fillable = [
        'ticket_id',
        'image',
    ];
}
