<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\DepositRequest;
use App\Http\Requests\Api\V1\FilterRequest;
use App\Http\Requests\Api\V1\TakeRequest;
use App\Http\Resources\TicketResource;
use App\Repositories\TicketRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct(private readonly TicketRepository $ticketRepository)
    {
    }

    public function deposit(DepositRequest $request): JsonResponse
    {
        $ticket = $this->ticketRepository->find($request->integer('ticket_id'));
        $data = $request->validated();

        if ($request->hasFile('images')) {
            $data['images'] = $this->multiUpload('tickets', $request->file('images'));
        }

        DB::transaction(function () use ($data, $ticket): void {
            $this->ticketRepository->deposit($data, $ticket);
            $this->ticketRepository->createImages($ticket, $data['images'] ?? null);
        });

        return $this->respondOk('200.tickets-deposit');
    }

    public function filter(FilterRequest $request): JsonResponse
    {
        $tickets = $this->ticketRepository->filter($request->validated());

        return $this->respondOk(t('200.tickets-filter'), TicketResource::collection($tickets));
    }

    public function take(TakeRequest $request): JsonResponse
    {
        if (auth()->user()->type === 0) {
            $this->ticketRepository->take($request->validated());

            return $this->respondOk(t('200.ticket-take'));
        }

        return $this->respondForbidden(t('403.ticket-take'));
    }

    public function user(): JsonResponse
    {
        $tickets = $this->ticketRepository->user();

        return $this->respondOk(t('200.tickets-user'), TicketResource::collection($tickets));
    }
}
