<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function index(): View
    {
        $users = $this->userRepository->paginate();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload('users', $request->file('image'));
        }

        $this->userRepository->create($data);

        return to_route('users.index')->with('success', __('success.create'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->delete('users', $user->getAttribute('image'));
            $data['image'] = $this->upload('users', $request->file('image'));
        }

        $this->userRepository->update($data, $user);

        return to_route('users.index')->with('success', __('success.update'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userRepository->delete($user);

        $this->delete('users', $user->getAttribute('image'));

        return back()->with('success', __('success.delete'));
    }
}
