<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class AssignTicketNumberCommand extends Command
{
    protected $description = 'Assign a new ticket number to the ticket';

    protected $signature = 'ticket assign:ticket-number';

    private static int $lastTicketNumber;

    public function __construct()
    {
        parent::__construct();

        $this->setLastTicketNumber();
    }

    public function handle(): void
    {
        if (count($tickets = $this->getTodayTickets()) == 0) {
            return;
        }

        foreach ($tickets as $ticket) {
            $this->updateTicket($ticket->id);
        }
    }

    private function getTodayTickets(): Collection
    {
        return Ticket::query()
            ->whereDate('created_at', now()->addDay())
            ->oldest('id')
            ->get('id');
    }

    private function setLastTicketNumber(): void
    {
        $lastTicketNumber = (int) Ticket::query()->max('ticket_number');

        self::$lastTicketNumber = $lastTicketNumber;
    }

    private function updateTicket(int $id): void
    {
        $ticket = Ticket::query()->find($id);

        if (is_null($ticket)) {
            return;
        }

        $ticket->update(['ticket_number' => ++self::$lastTicketNumber]);
    }
}