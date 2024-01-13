<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'ticket_number' => $this->resource->ticket_number,
            'customer_address' => $this->resource->customer_address,
            'longitude' => $this->resource->longitude,
            'latitude' => $this->resource->latitude,
            'customer_name' => $this->resource->customer_name,
            'customer_phone' => $this->resource->customer_phone,
            'user_id' => $this->resource->user_id,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'appliance' => new ApplianceResource($this->whenLoaded('appliance')),
            'fee' => new FeeResource($this->whenLoaded('fee')),
            'note' => $this->resource->note,
            'status' => $this->resource->status ?: 'new',
            'fee_note' => $this->resource->fee_note,
            'parts_fee' => $this->resource->parts_fee,
            'total_fee' => $this->resource->total_fee,
            'check_number' => $this->resource->check_number,
            'credit_card_number' => $this->resource->credit_card_number,
            'cash_amount' => $this->resource->cash_amount,
            'check_amount' => $this->resource->check_amount,
            'credit_card_amount' => $this->resource->credit_card_amount,
            'zelle_amount' => $this->resource->zelle_amount,
            'reschedule_date' => $this->getRescheduleDate(),
            'start_time' => $this->getStartTime(),
            'end_time' => $this->getEndTime(),
        ];
    }

    private function getEndTime(): string
    {
        return Carbon::make($this->resource->end_time)->format('H:i');
    }

    private function getRescheduleDate(): string
    {
        return Carbon::make($this->resource->reschedule_date)->format('n.j.Y');
    }

    private function getStartTime(): string
    {
        return Carbon::make($this->resource->start_time)->format('H:i');
    }
}
