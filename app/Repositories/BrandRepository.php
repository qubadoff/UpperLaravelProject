<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository
{
    public function create(array $data): void
    {
        Brand::query()->create($data);
    }

    public function delete(Brand $brand): void
    {
        $brand->delete();
    }

    public function get(): Collection
    {
        return Brand::query()
            ->where('status', 1)
            ->get(['id', 'name']);
    }

    public function paginate(): LengthAwarePaginator
    {
        return Brand::query()
            ->select(['id', 'name', 'status'])
            ->latest('id')
            ->paginate();
    }

    public function update(array $data, Brand $brand): void
    {
        $brand->update($data);
    }
}
