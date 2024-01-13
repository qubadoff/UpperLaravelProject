<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    public function __construct(private readonly BrandRepository $brandRepository)
    {
    }

    public function index(): View
    {
        $brands = $this->brandRepository->paginate();

        return view('brands.index', [
            'brands' => $brands,
        ]);
    }

    public function create(): View
    {
        return view('brands.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $this->brandRepository->create($request->validated());

        return to_route('brands.index')->with('success', __('success.create'));
    }

    public function edit(Brand $brand): View
    {
        return view('brands.edit', [
            'brand' => $brand,
        ]);
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $this->brandRepository->update($request->validated(), $brand);

        return to_route('brands.index')->with('success', __('success.update'));
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $this->brandRepository->delete($brand);

        return back()->with('success', __('success.delete'));
    }
}
