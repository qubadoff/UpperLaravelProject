<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

class LoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uid' => [
                'required',
                'integer',
                'digits:8',
            ],
            'password' => [
                'required',
                'min:8',
            ],
        ];
    }
}
