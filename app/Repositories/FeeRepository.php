<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Fee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class FeeRepository
{
    public function create(array $data): void
    {
        Fee::query()->create($data);
    }

    public function delete(Fee $fee): void
    {
        $fee->delete();
    }

    public function get(): Collection
    {
        return Fee::query()
            ->where('status', 1)
            ->get(['id', 'price']);
    }

    public function paginate(): LengthAwarePaginator
    {
        return Fee::query()
            ->select(['id', 'price', 'status'])
            ->latest('id')
            ->paginate();
    }

    public function update(array $data, Fee $fee): void
    {
        $fee->update($data);
    }
}
