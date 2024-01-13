<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Repositories\AdminRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private readonly AdminRepository $adminRepository)
    {
    }

    public function loginView(): View
    {
        return view('login.index');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if ($this->adminRepository->unauthorized($credentials, $remember)) {
            return back()->with('warning', __('warning.login'));
        }

        return to_route('dashboard')->with('success', __('success.login'));
    }

    public function logout(): RedirectResponse
    {
        $this->adminRepository->logout();

        return to_route('login.view')->with('success', __('success.logout'));
    }
}
