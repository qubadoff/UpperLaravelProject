<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFeeRequest;
use App\Http\Requests\Admin\UpdateFeeRequest;
use App\Models\Fee;
use App\Repositories\FeeRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FeeController extends Controller
{
    public function __construct(private readonly FeeRepository $feeRepository)
    {
    }

    public function index(): View
    {
        $fees = $this->feeRepository->paginate();

        return view('fees.index', [
            'fees' => $fees,
        ]);
    }

    public function create(): View
    {
        return view('fees.create');
    }

    public function store(StoreFeeRequest $request): RedirectResponse
    {
        $this->feeRepository->create($request->validated());

        return to_route('fees.index')->with('success', __('success.create'));
    }

    public function edit(Fee $fee): View
    {
        return view('fees.edit', [
            'fee' => $fee,
        ]);
    }

    public function update(UpdateFeeRequest $request, Fee $fee): RedirectResponse
    {
        $this->feeRepository->update($request->validated(), $fee);

        return to_route('fees.index')->with('success', __('success.update'));
    }

    public function destroy(Fee $fee): RedirectResponse
    {
        $this->feeRepository->delete($fee);

        return back()->with('success', __('success.delete'));
    }
}
