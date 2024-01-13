<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
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
            'reschedule_date' => 'reschedule date',
            'start_time' => 'start time',
            'end_time' => 'end time',
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
        ];
    }
}
