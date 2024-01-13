<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

abstract class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(
            Arr::first($validator->errors()->all())
        );
    }
}
