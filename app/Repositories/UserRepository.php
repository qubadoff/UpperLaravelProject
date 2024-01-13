<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function count(): int
    {
        return User::query()->count();
    }

    public function create(array $data): void
    {
        $data = $this->setCreateData($data);

        User::query()->create($data);
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function detail(): Authenticatable
    {
        return auth()->user();
    }

    public function get(): Collection
    {
        return User::all(['id', 'name', 'surname']);
    }

    public function internal(): Collection
    {
        return User::query()
            ->where('type', 1)
            ->get(['id', 'name', 'surname']);
    }

    public function logout(): void
    {
        auth()->logout();
        auth()->user()->tokens()->delete();
    }

    public function paginate(): LengthAwarePaginator
    {
        return User::query()
            ->select(['id', 'uid', 'name', 'surname', 'image', 'birthdate', 'phone', 'type'])
            ->latest('id')
            ->paginate();
    }

    public function payments(): Collection
    {
        return Payment::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->get(['id', 'from_date', 'to_date', 'amount']);
    }

    public function token(): string
    {
        return auth()->user()->createToken(uniqid())->plainTextToken;
    }

    public function unauthorized(array $credentials): bool
    {
        return ! auth()->attempt($credentials);
    }

    public function update(array $data, User $user): void
    {
        $data = $this->setUpdateData($data, $user);

        $user->update($data);
    }

    private function existUID(int $uid): bool
    {
        return User::query()
            ->where('uid', $uid)
            ->exists();
    }

    private function generateUID(int $length): int
    {
        return rand(10 ** $length, 10 * ($length + 1) - 1);
    }

    private function setCreateData(array $data): array
    {
        do {
            $data['uid'] = $this->generateUID(8);
        } while ($this->existUID($data['uid']));

        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    private function setUpdateData(array $data, User $user): array
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $user->getAttribute('password');
        }

        return $data;
    }
}
