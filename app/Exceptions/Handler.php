<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    public function register(): void
    {
        $this->renderable(function (Throwable $exception, Request $request) {
            if ($request->is('api/*')) {
                return $this->apiExceptions($exception);
            }
        });
    }

    private function apiExceptions(Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return $this->respondUnauthorized(t('401.authentication'));
        }

        if ($exception instanceof ValidationException) {
            return $this->respondUnprocessableEntity($exception->getMessage());
        }
    }
}
