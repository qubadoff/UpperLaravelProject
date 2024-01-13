<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\AssignTicketNumberCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->command(AssignTicketNumberCommand::class)
            ->dailyAt('21:00')
            ->onFailure(function () {
                $this->writeLog('AssignTicketNumberCommand => FAIL');
            })
            ->onSuccess(function () {
                $this->writeLog('AssignTicketNumberCommand => SUCCESS');
            });
    }

    private function writeLog(string $message): void
    {
        logger()->channel('cron')->info($message);
    }
}
