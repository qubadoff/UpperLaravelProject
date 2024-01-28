<?php

namespace App\Http\Controllers\Technicians;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TechnicianController extends Controller
{
    public function __construct(private readonly TicketRepository $ticketRepository){}

    public function login(): View
    {
        return \view('Technicians.login');
    }

    public function logout()
    {
        Auth::logout();

        return to_route('technician.login');
    }

    public function loginPost(Request $request)
    {
        $data  = $request->validate([
            'uid' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($data))
        {
            Auth::user();
            return to_route('technician.dashboard');
        } else {
            return back()->with('warning', 'Invalid ID or Password !');
        }
    }

    public function dashboard(Request $request): View
    {
        $all = Ticket::where('user_id', \auth()->user()->id)->count();
        $new = Ticket::where('user_id', \auth()->user()->id)
            ->where('status', NULL)
            ->count();
        $canceled = Ticket::where('user_id', \auth()->user()->id)
            ->where('status', Status::CANCELED)
            ->count();
        $completed = Ticket::where('user_id', \auth()->user()->id)
            ->where('status', Status::COMPLETED)
            ->count();
        $part_ordered = Ticket::where('user_id', \auth()->user()->id)
            ->where('status', Status::PART_ORDERED)
            ->count();
        $recall = Ticket::where('user_id', \auth()->user()->id)
            ->where('status', Status::RECALL)
            ->count();
        $reschedule = Ticket::where('user_id', \auth()->user()->id)
            ->where('status', Status::RESCHEDULE)
            ->count();

        $reports = $this->ticketRepository->getRevenueReportPaginatedForSingleTechnician($request);
        $totalReport = $this->ticketRepository->getRevenueSummaryReportForSingleTechnician($request);



        $all_tickets = Ticket::where('user_id', \auth()->user()->id)->get();



        return \view('Technicians.dashboard', compact('all',
            'new',
            'canceled',
            'completed',
            'part_ordered',
            'recall',
            'reschedule',
            'all_tickets',
            'reports',
            'totalReport',
        ));
    }
}
