<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Repositories\AdminRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly AdminRepository $adminRepository)
    {
    }

    public function profileView(): View
    {
        return view('profile.index');
    }

    public function profile(ProfileRequest $request): RedirectResponse
    {
        $this->adminRepository->profile($request->validated());

        return to_route('dashboard')->with('success', __('success.profile'));
    }
}
