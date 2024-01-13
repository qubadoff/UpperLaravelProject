<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\File;

class UpdateTicketRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'customer_address' => 'customer address',
            'customer_name' => 'customer name',
            'customer_phone' => 'customer phone',
            'user_id' => 'technician',
            'brand_id' => 'brand',
            'appliance_id' => 'appliance',
            'fee_id' => 'fee',
            'show_home' => 'show home',
            'parts_fee' => 'parts fee',
            'fee_note' => 'fee note',
            'check_number' => 'check number',
            'credit_card_number' => 'credit card number',
            'cash_amount' => 'cash amount',
            'check_amount' => 'check amount',
            'credit_card_amount' => 'credit card amount',
            'zelle_amount' => 'zelle amount',
            'reschedule_date' => 'reschedule date',
            'start_time' => 'start time',
            'end_time' => 'end time',
            'images.*' => 'images',
            'delete_images' => 'delete images',
        ];
    }

    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'customer_address' => [
                'required',
                'max:80',
            ],
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
            'customer_name' => [
                'required',
                'max:50',
            ],
            'customer_phone' => [
                'required',
                'max:20',
            ],
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')->where('type', 1),
            ],
            'brand_id' => [
                'required',
                Rule::exists('brands', 'id')->where('status', 1),
            ],
            'appliance_id' => [
                'required',
                Rule::exists('appliances', 'id')->where('status', 1),
            ],
            'fee_id' => [
                'required',
                Rule::exists('fees', 'id')->where('status', 1),
            ],
            'note' => [
                'nullable',
                'max:80',
            ],
            'status' => [
                'nullable',
                new Enum(Status::class),
            ],
            'show_home' => [
                'required',
                'boolean',
                Rule::in([0, 1]),
            ],
            'parts_fee' => [
                'nullable',
                'numeric',
            ],
            'fee_note' => [
                'nullable',
                'max:100',
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
            'reschedule_date' => [
                'required',
                'date_format:n.j.Y',
            ],
            'start_time' => [
                'required',
                'date_format:G:i',
                'before:end_time',
            ],
            'end_time' => [
                'required',
                'date_format:G:i',
                'after:start_time',
            ],
            'images' => [
                'nullable',
            ],
            'images.*' => [
                'image',
                File::types(['jpg', 'jpeg', 'png'])->max(500),
            ],
            'delete_images' => [
                'nullable',
                Rule::exists('ticket_images', 'id'),
            ],
        ];
    }
}
