<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateUserRequest extends FormRequest
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
                'alpha',
                'max:20',
            ],
            'surname' => [
                'required',
                'alpha',
                'max:30',
            ],
            'image' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png'])->max(500),
            ],
            'birthdate' => [
                'required',
                'date',
                'date_format:Y-m-d',
            ],
            'phone' => [
                'required',
                'integer',
            ],
            'password' => [
                'nullable',
                'min:8',
            ],
            'type' => [
                'required',
                'boolean',
                Rule::in([0, 1]),
            ],
        ];
    }
}
