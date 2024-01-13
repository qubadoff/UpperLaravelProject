<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {}

    public function detail(): JsonResponse
    {
        $users = $this->userRepository->detail();

        return $this->respondOk(t('200.user-detail'), new UserResource($users));
    }

    public function payments(): JsonResponse
    {
        $payments = $this->userRepository->payments();

        return $this->respondOk(t('200.user-payments'), PaymentResource::collection($payments));
    }
}
