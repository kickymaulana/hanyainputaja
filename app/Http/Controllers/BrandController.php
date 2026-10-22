<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Brands/Index', ['brands' => Brand::query()->orderBy('name')->get(['id', 'name', 'is_active'])]);
    }

    public function create(): Response
    {
        return Inertia::render('Brands/Create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        Brand::query()->create($request->validated());

        return to_route('brands.index')->with('success', 'Merek berhasil ditambahkan.');
    }

    public function edit(Brand $brand): Response
    {
        return Inertia::render('Brands/Edit', ['brand' => $brand->only(['id', 'name', 'is_active'])]);
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return to_route('brands.index')->with('success', 'Merek berhasil diperbarui.');
    }
}
