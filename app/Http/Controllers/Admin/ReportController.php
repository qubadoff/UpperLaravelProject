<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly TicketRepository $ticketRepository)
    {
    }

    public function showTicketRevenueReport(Request $request): View
    {
        $reports = $this->ticketRepository->getRevenueReportPaginated($request);
        $statuses = Status::cases();
        $status = $this->ticketRepository->status($request);
        $all = $status->count();
        $new = $status->whereNull('status')->count();
        $canceled = $status->where('status', Status::CANCELED)->count();
        $completed = $status->where('status', Status::COMPLETED)->count();
        $partOrdered = $status->where('status', Status::PART_ORDERED)->count();
        $recall = $status->where('status', Status::RECALL)->count();
        $reschedule = $status->where('status', Status::RESCHEDULE)->count();
        $totalReport = $this->ticketRepository->getRevenueSummaryReport($request);

        return view('reports.ticket_revenue', [
            'all' => $all,
            'canceled' => $canceled,
            'completed' => $completed,
            'new' => $new,
            'partOrdered' => $partOrdered,
            'recall' => $recall,
            'reports' => $reports,
            'totalReport' => $totalReport,
            'reschedule' => $reschedule,
            'statuses' => $statuses,
        ]);
    }
}
