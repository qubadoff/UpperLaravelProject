<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Enums\Status;
use Illuminate\Validation\Rule;

class FilterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'search' => [
                'nullable',
                'integer',
            ],
            'start_date' => [
                'required',
                'date_format:n.j.Y',
            ],
            'end_date' => [
                'required',
                'date_format:n.j.Y',
            ],
            'status' => [
                'nullable',
                Rule::in(Status::values(true)),
            ],
        ];
    }
}
