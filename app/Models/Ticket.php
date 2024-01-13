<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => Status::class,
        'reschedule_date' => 'datetime:Y-m-d',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'executed_at' => 'datetime',
    ];

    protected $fillable = [
        'ticket_number',
        'customer_address',
        'latitude',
        'longitude',
        'customer_name',
        'customer_phone',
        'admin_id',
        'user_id',
        'brand_id',
        'appliance_id',
        'fee_id',
        'note',
        'status',
        'show_home',
        'fee_note',
        'parts_fee',
        'total_fee',
        'check_number',
        'credit_card_number',
        'cash_amount',
        'check_amount',
        'credit_card_amount',
        'zelle_amount',
        'reschedule_date',
        'start_time',
        'end_time',
        'executed_at',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function appliance(): BelongsTo
    {
        return $this->belongsTo(Appliance::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(TicketImage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
