<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminRepository
{
    public function create(array $data): void
    {
        $data = $this->setCreateData($data);

        Admin::query()->create($data);
    }

    public function delete(Admin $admin): void
    {
        $admin->delete();
    }

    public function logout(): void
    {
        auth('admin')->logout();
    }

    public function paginate(): LengthAwarePaginator
    {
        return Admin::query()
            ->select(['id', 'name', 'surname', 'email'])
            ->latest('id')
            ->paginate();
    }

    public function profile(array $data): void
    {
        $data = $this->setUpdateData($data, auth()->user());

        auth('admin')->user()->update($data);
    }

    public function unauthorized(array $credentials, bool $remember): bool
    {
        return ! auth('admin')->attempt($credentials, $remember);
    }

    public function update(array $data, Admin $admin): void
    {
        $data = $this->setUpdateData($data, $admin);

        $admin->update($data);
    }

    private function setCreateData(array $data): array
    {
        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    private function setUpdateData(array $data, Admin|Authenticatable $admin): array
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $admin->getAttribute('password');
        }

        return $data;
    }
}
