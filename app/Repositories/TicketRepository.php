<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Fee;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TicketRepository
{
    private string $commission;
    private string $dateCompleted = 'DATE_FORMAT(executed_at, "%c.%e.%Y %H:%i")';

    private string $fullPartsPrice = 'IFNULL(parts_fee, 0)';

    private string $revenue;

    private string $totalCard = 'IFNULL(credit_card_amount, 0)';

    private string $totalCardPercent = '0.035 * IFNULL(credit_card_amount, 0)';

    private string $totalJob = 'IFNULL(cash_amount, 0) + IFNULL(check_amount, 0) + IFNULL(zelle_amount, 0)';

    public function __construct()
    {}

    public function count(): int
    {
        return Ticket::query()->count();
    }

    public function create(array $data): void
    {
        $data = $this->setCreateData($data);

        Ticket::query()->create($data);
    }

    public function createImages(Model $ticket, ?array $images): void
    {
        if (is_null($images)) {
            return;
        }

        $ticket->images()->createMany($images);
    }

    public function delete(Ticket $ticket): void
    {
        $ticket->delete();
    }

    public function deleteImages(Ticket $ticket): void
    {
        $ticket->images()->delete();
    }

    public function deleteImagesById(Ticket $ticket, array $id): void
    {
        $ticket->images()->whereIn('id', $id)->delete();
    }

    public function deposit(array $data, Model $ticket): void
    {
        $data = $this->setDepositData($data, $ticket);

        $ticket->update($data);
    }

    public function filter(array $data): Collection
    {
        $startDate = $this->changeDateFormat($data['start_date']);
        $endDate = $this->changeDateFormat($data['end_date']);

        return Ticket::query()
            ->with('appliance', function ($query): void {
                $query->where('status', 1)->get(['id', 'name']);
            })
            ->with('brand', function ($query): void {
                $query->where('status', 1)->get(['id', 'name']);
            })
            ->with('fee', function ($query): void {
                $query->where('status', 1)->get(['id', 'price']);
            })
            ->when(isset($data['status']) && $data['status'] !== 'all', function (Builder $query) use ($data): Builder {
                return $query->where('status', $data['status']);
            })
            ->when(isset($data['search']), function (Builder $query) use ($data): Builder {
                return $query->where('ticket_number', 'like', "%{$data['search']}%");
            })
            ->where('user_id', auth()->id())
            ->whereBetween(DB::raw('date_format(reschedule_date, "%Y-%m-%d")'), [$startDate, $endDate])
            ->whereNotNull('status')
            ->latest('id')
            ->get([
                'id',
                'ticket_number',
                'customer_address',
                'longitude',
                'latitude',
                'customer_name',
                'customer_phone',
                'user_id',
                'brand_id',
                'appliance_id',
                'fee_id',
                'note',
                'status',
                'fee_note',
                'parts_fee',
                'total_fee',
                'check_number',
                'credit_card_number',
                'cash_amount',
                'check_amount',
                'credit_card_amount',
                'zelle_amount',
                'reschedule_date',
                'start_time',
                'end_time',
            ]);
    }

    public function find(int $id): ?Model
    {
        return Ticket::query()->find($id);
    }

    public function getRevenueReportPaginated(Request $request): LengthAwarePaginator
    {
        $this->revenue = "{$this->totalJob} + {$this->totalCard} - {$this->totalCardPercent} - {$this->fullPartsPrice}";
        $this->commission = "0.4 * ({$this->revenue})";

        return Ticket::query()
            ->select([
                'id',
                'status',
                'ticket_number as job',
                'customer_name',
                DB::raw("{$this->dateCompleted} as date_completed"),
                DB::raw("{$this->totalJob} as total_job"),
                DB::raw("{$this->totalCard} as total_card"),
                DB::raw("{$this->totalCardPercent} as total_card_percent"),
                DB::raw("{$this->fullPartsPrice} as full_parts_price"),
                DB::raw("{$this->revenue} as revenue"),
                DB::raw("$this->commission as commission"),
                DB::raw("
                    CONCAT(
                        CASE
                            WHEN cash_amount <> 0.00 THEN CONCAT('<br> cash - ', cash_amount, '$')
                            ELSE ''
                        END,
                        CASE
                            WHEN check_amount <> 0.00 THEN CONCAT('<br> check - ', check_amount, '$')
                            ELSE ''
                        END,
                        CASE
                            WHEN credit_card_amount <> 0.00 THEN CONCAT('<br> credit card - ', credit_card_amount, '$')
                            ELSE ''
                        END,
                        CASE
                            WHEN zelle_amount <> 0.00 THEN CONCAT('<br> zelle - ', zelle_amount, '$')
                            ELSE ''
                        END
                    ) as payment_type
                "),
                'fee_note as work_description',
            ])
            ->whereNotNull('ticket_number')
            ->whereDate('reschedule_date', '<', now()->addDay())
            ->when($request->filled('job'), function (Builder $query) use ($request): Builder {
                $ticketNumber = $request->get('job');

                return $query->where('ticket_number', 'LIKE', "%{$ticketNumber}%");
            })
            ->when($request->filled('customer_name'), function (Builder $query) use ($request): Builder {
                $customerName = $request->get('customer_name');

                return $query->where('customer_name', 'LIKE', "%{$customerName}%");
            })
            ->when($request->filled('date_completed'), function (Builder $query) use ($request): Builder {
                $dateCompleted = $this->changeDateFormat($request->get('date_completed'));

                return $query->whereRaw("DATE_FORMAT(executed_at, '%Y-%m-%d') LIKE ?", ["%{$dateCompleted}%"]);
            })
            ->when($request->filled('total_job'), function (Builder $query) use ($request): Builder {
                $totalJob = $request->get('total_job');

                return $query->whereRaw("$this->totalJob LIKE ?", ["%{$totalJob}%"]);
            })
            ->when($request->filled('total_card'), function (Builder $query) use ($request): Builder {
                $totalCard = $request->get('total_card');

                return $query->whereRaw("$this->totalCard LIKE ?", ["%{$totalCard}%"]);
            })
            ->when($request->filled('total_card_percent'), function (Builder $query) use ($request): Builder {
                $totalCardPercent = $request->get('total_card_percent');

                return $query->whereRaw("$this->totalCardPercent LIKE ?", ["%{$totalCardPercent}%"]);
            })
            ->when($request->filled('full_parts_price'), function (Builder $query) use ($request): Builder {
                $fullPartsPrice = $request->get('full_parts_price');

                return $query->whereRaw("$this->fullPartsPrice LIKE ?", ["%{$fullPartsPrice}%"]);
            })
            ->when($request->filled('revenue'), function (Builder $query) use ($request): Builder {
                $revenue = $request->get('revenue');

                return $query->whereRaw("$this->revenue LIKE ?", ["%{$revenue}%"]);
            })
            ->when($request->filled('commission'), function (Builder $query) use ($request): Builder {
                $commission = $request->get('commission');

                return $query->whereRaw("$this->commission LIKE ?", ["%{$commission}%"]);
            })
            ->when($request->filled('payment_type'), function (Builder $query) use ($request): Builder {
                $paymentType = $request->get('payment_type');

                return $query->whereRaw("IFNULL({$paymentType}_amount, 0) <> 0");
            })
            ->when($request->filled('work_description'), function (Builder $query) use ($request): Builder {
                $workDescription = $request->get('work_description');

                return $query->where('fee_note', 'LIKE', "%{$workDescription}%");
            })
            ->when($request->filled(['from_date', 'to_date']), function (Builder $query) use ($request): Builder {
                $fromDate = $this->changeDateFormat($request->get('from_date'));
                $toDate = $this->changeDateFormat($request->get('to_date'));

                return $query->whereBetween('reschedule_date', [$fromDate, $toDate]);
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technician = $request->get('technician');

                    return $query->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$technician}%"]);
                });
            })
            ->latest('id')
            ->paginate();
    }

    public function getRevenueReportPaginatedForSingleTechnician(Request $request): LengthAwarePaginator
    {
        $percent = auth()->user()->percent_count / 100;
        $this->revenue = "{$this->totalJob} + {$this->totalCard} - {$this->totalCardPercent} - {$this->fullPartsPrice}";
        $this->commission = "$percent * ({$this->revenue})";

        return Ticket::query()
            ->select([
                'id',
                'status',
                'ticket_number as job',
                'customer_name',
                DB::raw("{$this->dateCompleted} as date_completed"),
                DB::raw("{$this->totalJob} as total_job"),
                DB::raw("{$this->totalCard} as total_card"),
                DB::raw("{$this->totalCardPercent} as total_card_percent"),
                DB::raw("{$this->fullPartsPrice} as full_parts_price"),
                DB::raw("{$this->revenue} as revenue"),
                DB::raw("$this->commission as commission"),
                DB::raw("
                    CONCAT(
                        CASE
                            WHEN cash_amount <> 0.00 THEN CONCAT('<br> cash - ', cash_amount, '$')
                            ELSE ''
                        END,
                        CASE
                            WHEN check_amount <> 0.00 THEN CONCAT('<br> check - ', check_amount, '$')
                            ELSE ''
                        END,
                        CASE
                            WHEN credit_card_amount <> 0.00 THEN CONCAT('<br> credit card - ', credit_card_amount, '$')
                            ELSE ''
                        END,
                        CASE
                            WHEN zelle_amount <> 0.00 THEN CONCAT('<br> zelle - ', zelle_amount, '$')
                            ELSE ''
                        END
                    ) as payment_type
                "),
                'fee_note as work_description',
            ])
            ->whereNotNull('ticket_number')
            ->whereDate('reschedule_date', '<', now()->addDay())
            ->when($request->filled('job'), function (Builder $query) use ($request): Builder {
                $ticketNumber = $request->get('job');

                return $query->where('ticket_number', 'LIKE', "%{$ticketNumber}%");
            })
            ->when($request->filled('customer_name'), function (Builder $query) use ($request): Builder {
                $customerName = $request->get('customer_name');

                return $query->where('customer_name', 'LIKE', "%{$customerName}%");
            })
            ->when($request->filled('date_completed'), function (Builder $query) use ($request): Builder {
                $dateCompleted = $this->changeDateFormat($request->get('date_completed'));

                return $query->whereRaw("DATE_FORMAT(executed_at, '%Y-%m-%d') LIKE ?", ["%{$dateCompleted}%"]);
            })
            ->when($request->filled('total_job'), function (Builder $query) use ($request): Builder {
                $totalJob = $request->get('total_job');

                return $query->whereRaw("$this->totalJob LIKE ?", ["%{$totalJob}%"]);
            })
            ->when($request->filled('total_card'), function (Builder $query) use ($request): Builder {
                $totalCard = $request->get('total_card');

                return $query->whereRaw("$this->totalCard LIKE ?", ["%{$totalCard}%"]);
            })
            ->when($request->filled('total_card_percent'), function (Builder $query) use ($request): Builder {
                $totalCardPercent = $request->get('total_card_percent');

                return $query->whereRaw("$this->totalCardPercent LIKE ?", ["%{$totalCardPercent}%"]);
            })
            ->when($request->filled('full_parts_price'), function (Builder $query) use ($request): Builder {
                $fullPartsPrice = $request->get('full_parts_price');

                return $query->whereRaw("$this->fullPartsPrice LIKE ?", ["%{$fullPartsPrice}%"]);
            })
            ->when($request->filled('revenue'), function (Builder $query) use ($request): Builder {
                $revenue = $request->get('revenue');

                return $query->whereRaw("$this->revenue LIKE ?", ["%{$revenue}%"]);
            })
            ->when($request->filled('commission'), function (Builder $query) use ($request): Builder {
                $commission = $request->get('commission');

                return $query->whereRaw("$this->commission LIKE ?", ["%{$commission}%"]);
            })
            ->when($request->filled('payment_type'), function (Builder $query) use ($request): Builder {
                $paymentType = $request->get('payment_type');

                return $query->whereRaw("IFNULL({$paymentType}_amount, 0) <> 0");
            })
            ->when($request->filled('work_description'), function (Builder $query) use ($request): Builder {
                $workDescription = $request->get('work_description');

                return $query->where('fee_note', 'LIKE', "%{$workDescription}%");
            })
            ->when($request->filled(['from_date', 'to_date']), function (Builder $query) use ($request): Builder {
                $fromDate = $this->changeDateFormat($request->get('from_date'));
                $toDate = $this->changeDateFormat($request->get('to_date'));

                return $query->whereBetween('reschedule_date', [$fromDate, $toDate]);
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technician = $request->get('technician');

                    return $query->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$technician}%"]);
                });
            })
            ->where('user_id', \auth()->user()->id)
            ->latest('id')
            ->paginate();
    }

    public function getRevenueSummaryReportForSingleTechnician(Request $request): ?Ticket
    {
        $percent = auth()->user()->percent_count / 100;
        $this->revenue = "{$this->totalJob} + {$this->totalCard} - {$this->totalCardPercent} - {$this->fullPartsPrice}";
        $this->commission = "$percent * ({$this->revenue})";

        return Ticket::query()
            ->select([
                DB::raw("SUM($this->totalJob) as total_job"),
                DB::raw("SUM($this->totalCard) as total_card"),
                DB::raw("SUM($this->totalCardPercent) as total_card_percent"),
                DB::raw("SUM($this->fullPartsPrice) as full_parts_price"),
                DB::raw("SUM($this->revenue) as revenue"),
                DB::raw("SUM($this->commission) as commission"),
                DB::raw("SUM($this->totalJob + $this->totalCard - $this->totalCardPercent) as total_job_total_card"),
                DB::raw("SUM($this->fullPartsPrice + $this->commission) as total_due"),
                DB::raw("SUM(IFNULL(cash_amount, 0)) as cash"),
                DB::raw("SUM($this->fullPartsPrice + $this->commission) - SUM(IFNULL(cash_amount, 0)) as td_minus_cash"),
            ])
            ->where('status', Status::COMPLETED)
            ->whereNotNull('ticket_number')
            ->whereDate('reschedule_date', '<', now()->addDay())
            ->when($request->filled('job'), function (Builder $query) use ($request): Builder {
                $ticketNumber = $request->get('job');

                return $query->where('ticket_number', 'LIKE', "%{$ticketNumber}%");
            })
            ->when($request->filled('customer_name'), function (Builder $query) use ($request): Builder {
                $customerName = $request->get('customer_name');

                return $query->where('customer_name', 'LIKE', "%{$customerName}%");
            })
            ->when($request->filled('date_completed'), function (Builder $query) use ($request): Builder {
                $dateCompleted = $this->changeDateFormat($request->get('date_completed'));

                return $query->whereRaw("DATE_FORMAT(executed_at, '%Y-%m-%d') LIKE ?", ["%{$dateCompleted}%"]);
            })
            ->when($request->filled('total_job'), function (Builder $query) use ($request): Builder {
                $totalJob = $request->get('total_job');

                return $query->whereRaw("$this->totalJob LIKE ?", ["%{$totalJob}%"]);
            })
            ->when($request->filled('total_card'), function (Builder $query) use ($request): Builder {
                $totalCard = $request->get('total_card');

                return $query->whereRaw("$this->totalCard LIKE ?", ["%{$totalCard}%"]);
            })
            ->when($request->filled('total_card_percent'), function (Builder $query) use ($request): Builder {
                $totalCardPercent = $request->get('total_card_percent');

                return $query->whereRaw("$this->totalCardPercent LIKE ?", ["%{$totalCardPercent}%"]);
            })
            ->when($request->filled('full_parts_price'), function (Builder $query) use ($request): Builder {
                $fullPartsPrice = $request->get('full_parts_price');

                return $query->whereRaw("$this->fullPartsPrice LIKE ?", ["%{$fullPartsPrice}%"]);
            })
            ->when($request->filled('revenue'), function (Builder $query) use ($request): Builder {
                $revenue = $request->get('revenue');

                return $query->whereRaw("$this->revenue LIKE ?", ["%{$revenue}%"]);
            })
            ->when($request->filled('commission'), function (Builder $query) use ($request): Builder {
                $commission = $request->get('commission');

                return $query->whereRaw("$this->commission LIKE ?", ["%{$commission}%"]);
            })
            ->when($request->filled('payment_type'), function (Builder $query) use ($request): Builder {
                $paymentType = $request->get('payment_type');

                return $query->whereRaw("IFNULL({$paymentType}_amount, 0) <> 0");
            })
            ->when($request->filled('work_description'), function (Builder $query) use ($request): Builder {
                $workDescription = $request->get('work_description');

                return $query->where('fee_note', 'LIKE', "%{$workDescription}%");
            })
            ->when($request->filled(['from_date', 'to_date']), function (Builder $query) use ($request): Builder {
                $fromDate = $this->changeDateFormat($request->get('from_date'));
                $toDate = $this->changeDateFormat($request->get('to_date'));

                return $query->whereBetween('reschedule_date', [$fromDate, $toDate]);
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technician = $request->get('technician');

                    return $query->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$technician}%"]);
                });
            })
            ->where('user_id', \auth()->user()->id)
            ->first();
    }

    public function getRevenueSummaryReport(Request $request): ?Ticket
    {
        $percent = auth()->user()->percent_count;
        $this->revenue = "{$this->totalJob} + {$this->totalCard} - {$this->totalCardPercent} - {$this->fullPartsPrice}";
        $this->commission = "0.4 * ({$this->revenue})";

        return Ticket::query()
            ->select([
                DB::raw("SUM($this->totalJob) as total_job"),
                DB::raw("SUM($this->totalCard) as total_card"),
                DB::raw("SUM($this->totalCardPercent) as total_card_percent"),
                DB::raw("SUM($this->fullPartsPrice) as full_parts_price"),
                DB::raw("SUM($this->revenue) as revenue"),
                DB::raw("SUM($this->commission) as commission"),
                DB::raw("SUM($this->totalJob + $this->totalCard - $this->totalCardPercent) as total_job_total_card"),
                DB::raw("SUM($this->fullPartsPrice + $this->commission) as total_due"),
                DB::raw("SUM(IFNULL(cash_amount, 0)) as cash"),
                DB::raw("SUM($this->fullPartsPrice + $this->commission) - SUM(IFNULL(cash_amount, 0)) as td_minus_cash"),
            ])
            ->where('status', Status::COMPLETED)
            ->whereNotNull('ticket_number')
            ->whereDate('reschedule_date', '<', now()->addDay())
            ->when($request->filled('job'), function (Builder $query) use ($request): Builder {
                $ticketNumber = $request->get('job');

                return $query->where('ticket_number', 'LIKE', "%{$ticketNumber}%");
            })
            ->when($request->filled('customer_name'), function (Builder $query) use ($request): Builder {
                $customerName = $request->get('customer_name');

                return $query->where('customer_name', 'LIKE', "%{$customerName}%");
            })
            ->when($request->filled('date_completed'), function (Builder $query) use ($request): Builder {
                $dateCompleted = $this->changeDateFormat($request->get('date_completed'));

                return $query->whereRaw("DATE_FORMAT(executed_at, '%Y-%m-%d') LIKE ?", ["%{$dateCompleted}%"]);
            })
            ->when($request->filled('total_job'), function (Builder $query) use ($request): Builder {
                $totalJob = $request->get('total_job');

                return $query->whereRaw("$this->totalJob LIKE ?", ["%{$totalJob}%"]);
            })
            ->when($request->filled('total_card'), function (Builder $query) use ($request): Builder {
                $totalCard = $request->get('total_card');

                return $query->whereRaw("$this->totalCard LIKE ?", ["%{$totalCard}%"]);
            })
            ->when($request->filled('total_card_percent'), function (Builder $query) use ($request): Builder {
                $totalCardPercent = $request->get('total_card_percent');

                return $query->whereRaw("$this->totalCardPercent LIKE ?", ["%{$totalCardPercent}%"]);
            })
            ->when($request->filled('full_parts_price'), function (Builder $query) use ($request): Builder {
                $fullPartsPrice = $request->get('full_parts_price');

                return $query->whereRaw("$this->fullPartsPrice LIKE ?", ["%{$fullPartsPrice}%"]);
            })
            ->when($request->filled('revenue'), function (Builder $query) use ($request): Builder {
                $revenue = $request->get('revenue');

                return $query->whereRaw("$this->revenue LIKE ?", ["%{$revenue}%"]);
            })
            ->when($request->filled('commission'), function (Builder $query) use ($request): Builder {
                $commission = $request->get('commission');

                return $query->whereRaw("$this->commission LIKE ?", ["%{$commission}%"]);
            })
            ->when($request->filled('payment_type'), function (Builder $query) use ($request): Builder {
                $paymentType = $request->get('payment_type');

                return $query->whereRaw("IFNULL({$paymentType}_amount, 0) <> 0");
            })
            ->when($request->filled('work_description'), function (Builder $query) use ($request): Builder {
                $workDescription = $request->get('work_description');

                return $query->where('fee_note', 'LIKE', "%{$workDescription}%");
            })
            ->when($request->filled(['from_date', 'to_date']), function (Builder $query) use ($request): Builder {
                $fromDate = $this->changeDateFormat($request->get('from_date'));
                $toDate = $this->changeDateFormat($request->get('to_date'));

                return $query->whereBetween('reschedule_date', [$fromDate, $toDate]);
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technician = $request->get('technician');

                    return $query->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$technician}%"]);
                });
            })
            ->first();
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        return Ticket::query()
            ->with(['admin:id,name,surname', 'user:id,name,surname,type', 'fee:id,price'])
            ->select([
                'id',
                'ticket_number',
                'customer_name',
                'customer_phone',
                'customer_address',
                'admin_id',
                'user_id',
                'fee_id',
                'status',
                DB::raw('concat(date_format(reschedule_date, "%c.%e.%Y"), " ", date_format(start_time, "%H:%i"), "-", date_format(end_time, "%H:%i")) as reschedule_at'),
            ])
            ->when($request->filled('ticket_number'), function (Builder $query) use ($request): Builder {
                $ticketNumber = $request->get('ticket_number');

                return $query->where('ticket_number', 'LIKE', "%{$ticketNumber}%");
            })
            ->when($request->filled('numbered_ticket') && $request->input('numbered_ticket') == 1, function (Builder $query) use ($request): Builder {
                return $query->whereNotNull('ticket_number');
            })
            ->when($request->filled('numbered_ticket') && $request->input('numbered_ticket') == 0, function (Builder $query) use ($request): Builder {
                return $query->whereNull('ticket_number');
            })
            ->when($request->filled('customer_name'), function (Builder $query) use ($request): Builder {
                $customerName = $request->get('customer_name');

                return $query->where('customer_name', 'LIKE', "%{$customerName}%");
            })
            ->when($request->filled('customer_phone'), function (Builder $query) use ($request): Builder {
                $customerPhone = $request->get('customer_phone');

                return $query->where('customer_phone', 'LIKE', "%{$customerPhone}%");
            })
            ->when($request->filled('customer_address'), function (Builder $query) use ($request): Builder {
                $customerAddress = $request->get('customer_address');

                return $query->where('customer_address', 'LIKE', "%{$customerAddress}%");
            })
            ->when($request->filled('admin'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('admin', function (Builder $query) use ($request): Builder {
                    $admin = $request->get('admin');

                    return $query->where(DB::raw('concat(name, " ", surname)'), 'LIKE', "%{$admin}%");
                });
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technician = $request->get('technician');

                    return $query->where(DB::raw('concat(name, " ", surname)'), 'LIKE', "%{$technician}%");
                });
            })
            ->when($request->filled('technician_type'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technicianType = $request->get('technician_type');

                    return $query->where('type', $technicianType);
                });
            })
            ->when($request->filled('fee'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('fee', function (Builder $query) use ($request): Builder {
                    $fee = $request->get('fee');

                    return $query->where('price', 'LIKE', "%{$fee}%");
                });
            })
            ->when($request->filled('status'), function (Builder $query) use ($request): Builder {
                $status = $request->get('status');

                return $query->where('status', $status);
            })
            ->when($request->filled(['from_date', 'to_date']), function (Builder $query) use ($request): Builder {
                $fromDate = $this->changeDateFormat($request->input('from_date'));
                $toDate = $this->changeDateFormat($request->input('to_date'));

                return $query->whereBetween('reschedule_date', [$fromDate, $toDate]);
            })
            ->latest('id')
            ->paginate();
    }

    public function pluckImageData(Ticket $ticket, array $ids, string $column): array
    {
        return $ticket->images()
            ->whereIn('id', $ids)
            ->pluck($column)
            ->toArray();
    }

    public function status(Request $request): Collection
    {
        return Ticket::query()
            ->when($request->filled('ticket_number'), function (Builder $query) use ($request): Builder {
                $ticketNumber = $request->get('ticket_number');

                return $query->where('ticket_number', 'LIKE', "%{$ticketNumber}%");
            })
            ->when($request->filled('numbered_ticket') && $request->input('numbered_ticket') == 1, function (Builder $query) use ($request): Builder {
                return $query->whereNotNull('ticket_number');
            })
            ->when($request->filled('numbered_ticket') && $request->input('numbered_ticket') == 0, function (Builder $query) use ($request): Builder {
                return $query->whereNull('ticket_number');
            })
            ->when($request->filled('customer_name'), function (Builder $query) use ($request): Builder {
                $customerName = $request->get('customer_name');

                return $query->where('customer_name', 'LIKE', "%{$customerName}%");
            })
            ->when($request->filled('customer_phone'), function (Builder $query) use ($request): Builder {
                $customerPhone = $request->get('customer_phone');

                return $query->where('customer_phone', 'LIKE', "%{$customerPhone}%");
            })
            ->when($request->filled('customer_address'), function (Builder $query) use ($request): Builder {
                $customerAddress = $request->get('customer_address');

                return $query->where('customer_address', 'LIKE', "%{$customerAddress}%");
            })
            ->when($request->filled('admin'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('admin', function (Builder $query) use ($request): Builder {
                    $admin = $request->get('admin');

                    return $query->where(DB::raw('concat(name, " ", surname)'), 'LIKE', "%{$admin}%");
                });
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technician = $request->get('technician');

                    return $query->where(DB::raw('concat(name, " ", surname)'), 'LIKE', "%{$technician}%");
                });
            })
            ->when($request->filled('technician_type'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    $technicianType = $request->get('technician_type');

                    return $query->where('type', $technicianType);
                });
            })
            ->when($request->filled('fee'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('fee', function (Builder $query) use ($request): Builder {
                    $fee = $request->get('fee');

                    return $query->where('price', 'LIKE', "%{$fee}%");
                });
            })
            ->when($request->filled('status'), function (Builder $query) use ($request): Builder {
                $status = $request->get('status');

                return $query->where('status', $status);
            })
            ->get(['status']);
    }

    public function take(array $data): void
    {
        $this->find($data['ticket_id'])->update([
            'user_id' => auth()->id(),
        ]);
    }

    public function update(array $data, Ticket $ticket): void
    {
        $data = $this->setUpdateData($data, $ticket);

        $ticket->update($data);
    }

    public function user(): Collection
    {
        return Ticket::query()
            ->with('appliance', function ($query): void {
                $query->where('status', 1)->get(['id', 'name']);
            })
            ->with('brand', function ($query): void {
                $query->where('status', 1)->get(['id', 'name']);
            })
            ->with('fee', function ($query): void {
                $query->where('status', 1)->get(['id', 'price']);
            })
            ->where('show_home', 1)
            ->where(function (Builder $query): Builder {
                $status = [Status::CANCELED, Status::COMPLETED];

                return $query->whereNotIn('status', $status)->orWhereNull('status');
            })
            ->whereDate('reschedule_date', now())
            ->when(auth()->user()->type === 1, function (Builder $query): Builder {
                return $query->where('user_id', auth()->id());
            }, function (Builder $query): Builder {
                return $query->where(function ($query): Builder {
                    return $query->where('user_id', auth()->id())->orWhereNull('user_id');
                });
            })
            ->latest('id')
            ->get([
                'id',
                'ticket_number',
                'customer_address',
                'longitude',
                'latitude',
                'customer_name',
                'customer_phone',
                'user_id',
                'brand_id',
                'appliance_id',
                'fee_id',
                'note',
                'status',
                'fee_note',
                'parts_fee',
                'total_fee',
                'check_number',
                'credit_card_number',
                'cash_amount',
                'check_amount',
                'credit_card_amount',
                'zelle_amount',
                'reschedule_date',
                'start_time',
                'end_time',
            ]);
    }

    private function calculateDeposit(array $data, Model $ticket): float
    {
        $total = 0;

        $total += empty($data['cash_amount']) ? $ticket->getAttribute('cash_amount') : $data['cash_amount'];
        $total += empty($data['check_amount']) ? $ticket->getAttribute('check_amount') : $data['check_amount'];
        $total += empty($data['credit_card_amount']) ? $ticket->getAttribute('credit_card_amount') : $data['credit_card_amount'];
        $total += empty($data['zelle_amount']) ? $ticket->getAttribute('zelle_amount') : $data['zelle_amount'];

        return $total;
    }

    private function changeDateFormat(string $date): string
    {
        [$month, $day, $year] = explode('.', $date);

        return Carbon::create($year, $month, $day)->format('Y-m-d');
    }

    private function getFeePrice(int|string $feeId): float
    {
        return Fee::query()->find($feeId)->getAttribute('price');
    }

    private function getTicketNumber(): int
    {
        $ticketNumber = (int) Ticket::query()->max('ticket_number');

        return ++$ticketNumber;
    }

    private function setCreateData(array $data): array
    {
        $data['total_fee'] = $this->getFeePrice($data['fee_id']);
        $data['reschedule_date'] = $this->changeDateFormat($data['reschedule_date']);
        $data['admin_id'] = auth('admin')->id();

        if ($data['reschedule_date'] === now()->format('Y-m-d')) {
            $data['ticket_number'] = $this->getTicketNumber();
        } else {
            $data['ticket_number'] = null;
        }

        return $data;
    }

    private function setDepositData(array $data, Model $ticket): array
    {
        if (isset($data['status']) && $data['status'] === Status::COMPLETED->value) {
            $data['executed_at'] = now()->format('Y-m-d H:i:s');
        }

        if (empty($data['fee_note'])) {
            $data['fee_note'] = $ticket->getAttribute('fee_note');
        } else {
            $data['fee_note'] = $data['fee_note'] . ' ' . $ticket->getAttribute('fee_note');
        }

        if (empty($data['parts_fee'])) {
            $data['parts_fee'] = $ticket->getAttribute('parts_fee');
        } else {
            $data['parts_fee'] += $ticket->getAttribute('parts_fee');
        }

        if (empty($data['check_number'])) {
            $data['check_number'] = $ticket->getAttribute('check_number');
        }

        if (empty($data['credit_card_number'])) {
            $data['credit_card_number'] = $ticket->getAttribute('credit_card_number');
        }

        if (empty($data['cash_amount'])) {
            $data['cash_amount'] = $ticket->getAttribute('cash_amount');
        } else {
            $data['cash_amount'] += $ticket->getAttribute('cash_amount');
        }

        if (empty($data['check_amount'])) {
            $data['check_amount'] = $ticket->getAttribute('check_amount');
        } else {
            $data['check_amount'] += $ticket->getAttribute('check_amount');
        }

        if (empty($data['credit_card_amount'])) {
            $data['credit_card_amount'] = $ticket->getAttribute('credit_card_amount');
        } else {
            $data['credit_card_amount'] += $ticket->getAttribute('credit_card_amount');
        }

        if (empty($data['zelle_amount'])) {
            $data['zelle_amount'] = $ticket->getAttribute('zelle_amount');
        } else {
            $data['zelle_amount'] += $ticket->getAttribute('zelle_amount');
        }

        $data['total_fee'] = $data['parts_fee'] + $this->calculateDeposit($data, $ticket);
        $data['show_home'] = 0;

        return $data;
    }

    private function setUpdateData(array $data, Ticket $ticket): array
    {
        $data['reschedule_date'] = $this->changeDateFormat($data['reschedule_date']);

        if (isset($data['status']) && $data['status'] === Status::COMPLETED->value) {
            $data['executed_at'] = now()->format('Y-m-d H:i:s');
        }

        $feePrice = $this->getFeePrice($data['fee_id']);

        if (empty($data['parts_fee'])) {
            $data['parts_fee'] = $ticket->getAttribute('parts_fee');
        } else {
            $data['parts_fee'] += $ticket->getAttribute('parts_fee');
        }

        $data['total_fee'] = $feePrice + $data['parts_fee'] + $this->calculateDeposit($data, $ticket);

        return $data;
    }
}
