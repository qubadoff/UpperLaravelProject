<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function __construct(private readonly AdminRepository $adminRepository)
    {
    }

    public function index(): View
    {
        $admins = $this->adminRepository->paginate();

        return view('admins.index', [
            'admins' => $admins,
        ]);
    }

    public function create(): View
    {
        return view('admins.create');
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $this->adminRepository->create($request->validated());

        return to_route('admins.index')->with('success', __('success.create'));
    }

    public function edit(Admin $admin): View
    {
        return view('admins.edit', [
            'admin' => $admin,
        ]);
    }

    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        $this->adminRepository->update($request->validated(), $admin);

        return to_route('admins.index')->with('success', __('success.update'));
    }

    public function destroy(Admin $admin): RedirectResponse
    {
        $this->adminRepository->delete($admin);

        return back()->with('success', __('success.delete'));
    }
}
