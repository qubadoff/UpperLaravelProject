<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    public function respondForbidden(string $message): JsonResponse
    {
        return $this->respond(Response::HTTP_FORBIDDEN, $message);
    }

    public function respondOk(string $message, mixed $data = null): JsonResponse
    {
        return $this->respond(Response::HTTP_OK, $message, $data);
    }

    public function respondUnauthorized(string $message): JsonResponse
    {
        return $this->respond(Response::HTTP_UNAUTHORIZED, $message);
    }

    public function respondUnprocessableEntity(string $message): JsonResponse
    {
        return $this->respond(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

    private function respond(int $status, string $message, mixed $data = null): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }
}
