<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreApplianceRequest;
use App\Http\Requests\Admin\UpdateApplianceRequest;
use App\Models\Appliance;
use App\Repositories\ApplianceRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ApplianceController extends Controller
{
    public function __construct(private readonly ApplianceRepository $applianceRepository)
    {
    }

    public function index(): View|RedirectResponse
    {
        $appliances = $this->applianceRepository->paginate();

        return view('appliances.index', [
            'appliances' => $appliances,
        ]);
    }

    public function create(): View
    {
        return view('appliances.create');
    }

    public function store(StoreApplianceRequest $request): RedirectResponse
    {
        $this->applianceRepository->create($request->validated());

        return to_route('appliances.index')->with('success', __('success.create'));
    }

    public function edit(Appliance $appliance): View
    {
        return view('appliances.edit', [
            'appliance' => $appliance,
        ]);
    }

    public function update(UpdateApplianceRequest $request, Appliance $appliance): RedirectResponse
    {
        $this->applianceRepository->update($request->validated(), $appliance);

        return to_route('appliances.index')->with('success', __('success.update'));
    }

    public function destroy(Appliance $appliance): RedirectResponse
    {
        $this->applianceRepository->delete($appliance);

        return back()->with('success', __('success.delete'));
    }
}
