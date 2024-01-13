<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentRepository
{
    public function create(array $data): void
    {
        $data = $this->setCreateData($data);

        Payment::query()->create($data);
    }

    public function delete(Payment $payment): void
    {
        $payment->delete();
    }

    public function paginate(Request $request): LengthAwarePaginator
    {
        return Payment::query()
            ->with('user:id,name,surname')
            ->select(['id', 'user_id', 'from_date', 'to_date', 'amount'])
            ->when($request->filled('id'), function (Builder $query) use ($request): Builder {
                return $query->where('id', 'LIKE', "%{$request->get('id')}%");
            })
            ->when($request->filled('technician'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    return $query->where(DB::raw('concat(name, " ", surname)'), 'LIKE', "%{$request->get('technician')}%");
                });
            })
            ->when($request->filled('technician_type'), function (Builder $query) use ($request): Builder {
                return $query->whereHas('user', function (Builder $query) use ($request): Builder {
                    return $query->where('type', $request->get('technician_type'));
                });
            })
            ->when($request->filled('amount'), function (Builder $query) use ($request): Builder {
                return $query->where('amount', 'LIKE', "%{$request->get('amount')}%");
            })
            ->when($request->filled('from_date'), function (Builder $query) use ($request): Builder {
                return $query->whereDate('from_date', $request->get('from_date'));
            })
            ->when($request->filled('to_date'), function (Builder $query) use ($request): Builder {
                return $query->whereDate('to_date', $request->get('to_date'));
            })
            ->latest('id')
            ->paginate();
    }

    private function changeDateFormat(string $date): string
    {
        [$month, $day, $year] = explode('.', $date);

        return Carbon::create($year, $month, $day)->format('Y-m-d');
    }

    private function setCreateData(array $data): array
    {
        $data['from_date'] = $this->changeDateFormat($data['from_date']);
        $data['to_date'] = $this->changeDateFormat($data['to_date']);

        return $data;
    }
}
