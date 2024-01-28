<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Traits\FireBaseNotificationTrait;

class TicketObserver
{
    use FireBaseNotificationTrait;
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        if (is_null($ticket->ticket_number))
        {
            $user = $ticket->user;

            $fmc_token = $user->fmc_token;

            $this->sendNotification($fmc_token);
        }
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        if (is_null($ticket->ticket_number))
        {
            $user = $ticket->user;

            $fmc_token = $user->fmc_token;

            $this->sendNotification($fmc_token);
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        if (is_null($ticket->ticket_number))
        {
            $user = $ticket->user;

            $fmc_token = $user->fmc_token;

            $this->sendNotification($fmc_token);
        }
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        if (is_null($ticket->ticket_number))
        {
            $user = $ticket->user;

            $fmc_token = $user->fmc_token;

            $this->sendNotification($fmc_token);
        }
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        if (is_null($ticket->ticket_number))
        {
            $user = $ticket->user;

            $fmc_token = $user->fmc_token;

            $this->sendNotification($fmc_token);
        }
    }
}
