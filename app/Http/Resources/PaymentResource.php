<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->resource->amount,
            'from_date' => $this->toFormat($this->resource->from_date),
            'to_date' => $this->toFormat($this->resource->to_date),
        ];
    }

    private function toFormat(string $date): string
    {
        return Carbon::make($date)->format('n.j.Y');
    }
}
