<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;

class TakeRequest extends BaseRequest
{
    public function attributes(): array
    {
        return [
            'ticket_id' => 'ticket id',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'ticket_id' => [
                'required',
                Rule::exists('tickets', 'id'),
            ],
        ];
    }
}
