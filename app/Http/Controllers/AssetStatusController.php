<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetStatusRequest;
use App\Http\Requests\UpdateAssetStatusRequest;
use App\Models\AssetStatus;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AssetStatusController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('AssetStatuses/Index', ['statuses' => AssetStatus::query()->orderBy('id')->get(['id', 'name', 'is_active'])]);
    }

    public function create(): Response
    {
        return Inertia::render('AssetStatuses/Create');
    }

    public function store(StoreAssetStatusRequest $request): RedirectResponse
    {
        AssetStatus::query()->create($request->validated());

        return to_route('asset-statuses.index')->with('success', 'Status aset berhasil ditambahkan.');
    }

    public function edit(AssetStatus $assetStatus): Response
    {
        return Inertia::render('AssetStatuses/Edit', ['status' => $assetStatus->only(['id', 'name', 'is_active'])]);
    }

    public function update(UpdateAssetStatusRequest $request, AssetStatus $assetStatus): RedirectResponse
    {
        $assetStatus->update($request->validated());

        return to_route('asset-statuses.index')->with('success', 'Status aset berhasil diperbarui.');
    }
}
