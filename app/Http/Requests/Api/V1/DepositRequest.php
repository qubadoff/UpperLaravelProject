<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Enums\Status;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\File;

class DepositRequest extends BaseRequest
{
    public function attributes(): array
    {
        return [
            'ticket_id' => 'ticket id',
            'fee_note' => 'fee note',
            'parts_fee' => 'parts fee',
            'check_number' => 'check number',
            'credit_card_number' => 'credit card number',
            'cash_amount' => 'cash amount',
            'check_amount' => 'check amount',
            'credit_card_amount' => 'credit card amount',
            'zelle_amount' => 'zelle amount',
            'images.*' => 'images',
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
            'status' => [
                'required',
                new Enum(Status::class),
            ],
            'fee_note' => [
                'nullable',
                'max:100',
            ],
            'parts_fee' => [
                'nullable',
                'numeric',
            ],
            'check_number' => [
                'nullable',
                'numeric',
            ],
            'credit_card_number' => [
                'nullable',
                'numeric',
            ],
            'cash_amount' => [
                'nullable',
                'numeric',
            ],
            'check_amount' => [
                'nullable',
                'numeric',
            ],
            'credit_card_amount' => [
                'nullable',
                'numeric',
            ],
            'zelle_amount' => [
                'nullable',
                'numeric',
            ],
            'images' => [
                'nullable',
            ],
            'images.*' => [
                'image',
                File::types(['jpg', 'jpeg', 'png'])->max(500),
            ],
        ];
    }
}
