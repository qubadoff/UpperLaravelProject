<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:40',
                Rule::unique('admins', 'email')->ignore(
                    auth('admin')->id()
                ),
            ],
            'password' => [
                'nullable',
                'min:8',
            ],
        ];
    }
}
