<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(): View
    {
        $ticketCount = $this->ticketRepository->count();
        $userCount = $this->userRepository->count();

        return view('dashboard.index', [
            'ticketCount' => $ticketCount,
            'userCount' => $userCount,
        ]);
    }
}
