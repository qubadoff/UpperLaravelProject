<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'from_date' => [
                'required',
                'date_format:n.j.Y',
            ],
            'to_date' => [
                'required',
                'date_format:n.j.Y',
            ],
        ];
    }
}
