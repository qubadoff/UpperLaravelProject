<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'price' => [
                'required',
                'numeric',
                Rule::unique('fees', 'price')->ignore(
                    $this->route()->parameter('fee')
                ),
            ],
            'status' => [
                'required',
                'boolean',
                Rule::in([0, 1]),
            ],
        ];
    }
}
