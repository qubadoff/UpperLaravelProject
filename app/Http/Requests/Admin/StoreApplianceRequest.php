<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplianceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:30',
                Rule::unique('appliances', 'name'),
            ],
            'status' => [
                'required',
                'boolean',
                Rule::in([0, 1]),
            ],
        ];
    }
}
