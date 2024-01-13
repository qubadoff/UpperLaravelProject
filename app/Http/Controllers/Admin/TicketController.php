<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTicketRequest;
use App\Http\Requests\Admin\UpdateTicketRequest;
use App\Models\Ticket;
use App\Repositories\ApplianceRepository;
use App\Repositories\BrandRepository;
use App\Repositories\FeeRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(
        private readonly ApplianceRepository $applianceRepository,
        private readonly BrandRepository $brandRepository,
        private readonly FeeRepository $feeRepository,
        private readonly TicketRepository $ticketRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function index(Request $request): View
    {
        $statuses = Status::cases();
        $tickets = $this->ticketRepository->paginate($request);
        $status = $this->ticketRepository->status($request);
        $all = $status->count();
        $new = $status->whereNull('status')->count();
        $canceled = $status->where('status', Status::CANCELED)->count();
        $completed = $status->where('status', Status::COMPLETED)->count();
        $partOrdered = $status->where('status', Status::PART_ORDERED)->count();
        $recall = $status->where('status', Status::RECALL)->count();
        $reschedule = $status->where('status', Status::RESCHEDULE)->count();

        return view('tickets.index', [
            'all' => $all,
            'canceled' => $canceled,
            'completed' => $completed,
            'new' => $new,
            'partOrdered' => $partOrdered,
            'recall' => $recall,
            'reschedule' => $reschedule,
            'statuses' => $statuses,
            'tickets' => $tickets,
        ]);
    }

    public function create(): View
    {
        $appliances = $this->applianceRepository->get();
        $brands = $this->brandRepository->get();
        $fees = $this->feeRepository->get();
        $users = $this->userRepository->internal();

        return view('tickets.create', [
            'appliances' => $appliances,
            'brands' => $brands,
            'fees' => $fees,
            'users' => $users,
        ]);
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $this->ticketRepository->create($request->validated());

        return to_route('tickets.index')->with('success', __('success.create'));
    }

    public function show(Ticket $ticket): View
    {
        return view('tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    public function edit(Ticket $ticket): View|RedirectResponse
    {
        $appliances = $this->applianceRepository->get();
        $brands = $this->brandRepository->get();
        $fees = $this->feeRepository->get();
        $users = $this->userRepository->internal();
        $statuses = Status::cases();

        return view('tickets.edit', [
            'appliances' => $appliances,
            'brands' => $brands,
            'fees' => $fees,
            'statuses' => $statuses,
            'ticket' => $ticket,
            'users' => $users,
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $ticket) {
            $this->ticketRepository->update($data, $ticket);

            if (isset($data['delete_images'])) {
                $ids = $this->ticketRepository->pluckImageData($ticket, $data['delete_images'], 'id');
                $images = $this->ticketRepository->pluckImageData($ticket, $data['delete_images'], 'image');
                $this->multiDelete('tickets', $images);
                $this->ticketRepository->deleteImagesById($ticket, $ids);
            }

            if ($request->hasFile('images')) {
                $images = $this->multiUpload('tickets', $request->file('images'));
                $this->ticketRepository->createImages($ticket, $images);
            }
        });

        return to_route('tickets.index')->with('success', __('success.update'));
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $images = $ticket->images()->pluck('image')->toArray();

        DB::transaction(function () use ($ticket): void {
            $this->ticketRepository->delete($ticket);
            $this->ticketRepository->deleteImages($ticket);
        });

        $this->multiDelete('tickets', $images);

        return back()->with('success', __('success.delete'));
    }

    public function deposit(Ticket $ticket): View
    {
        return view('tickets.deposit', [
            'ticket' => $ticket,
        ]);
    }
}
