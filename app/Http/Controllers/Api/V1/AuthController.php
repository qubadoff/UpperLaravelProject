<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if ($this->userRepository->unauthorized($credentials)) {
            return $this->respondUnauthorized(t('401.login'));
        }

        $token = $this->userRepository->token();

        return $this->respondOk(t('200.login'), $token);
    }

    public function logout(): JsonResponse
    {
        $this->userRepository->logout();

        return $this->respondOk(t('200.logout'));
    }
}
