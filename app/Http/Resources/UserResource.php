<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'surname' => $this->resource->surname,
            'image' => $this->getImage(),
            'birthdate' => $this->getBirthdate(),
            'phone' => $this->resource->phone,
            'type' => $this->resource->type,
        ];
    }

    private function getBirthdate(): string
    {
        return Carbon::make($this->resource->birthdate)->format('n.j.Y');
    }

    private function getImage(): ?string
    {
        $image = $this->resource->image;

        if (! file_exists(public_path($path = "uploads/users/{$image}")) || is_null($image)) {
            return null;
        }

        return asset($path);
    }
}
