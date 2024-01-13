<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends FormRequest
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
                Rule::unique('admins', 'email'),
            ],
            'password' => [
                'required',
                'min:8',
            ],
        ];
    }
}
