<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
                'max:20',
                Rule::unique('brands', 'name')->ignore(
                    $this->route()->parameter('brand')
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
