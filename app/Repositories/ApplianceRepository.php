<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Appliance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ApplianceRepository
{
    public function create(array $data): void
    {
        Appliance::query()->create($data);
    }

    public function delete(Appliance $appliance): void
    {
        $appliance->delete();
    }

    public function get(): Collection
    {
        return Appliance::query()
            ->where('status', 1)
            ->get(['id', 'name']);
    }

    public function paginate(): LengthAwarePaginator
    {
        return Appliance::query()
            ->select(['id', 'name', 'status'])
            ->latest('id')
            ->paginate();
    }

    public function update(array $data, Appliance $appliance): void
    {
        $appliance->update($data);
    }
}
