<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetConditionRequest;
use App\Http\Requests\UpdateAssetConditionRequest;
use App\Models\AssetCondition;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AssetConditionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('AssetConditions/Index', ['conditions' => AssetCondition::query()->orderBy('id')->get(['id', 'name', 'is_active'])]);
    }

    public function create(): Response
    {
        return Inertia::render('AssetConditions/Create');
    }

    public function store(StoreAssetConditionRequest $request): RedirectResponse
    {
        AssetCondition::query()->create($request->validated());

        return to_route('asset-conditions.index')->with('success', 'Kondisi aset berhasil ditambahkan.');
    }

    public function edit(AssetCondition $assetCondition): Response
    {
        return Inertia::render('AssetConditions/Edit', ['condition' => $assetCondition->only(['id', 'name', 'is_active'])]);
    }

    public function update(UpdateAssetConditionRequest $request, AssetCondition $assetCondition): RedirectResponse
    {
        $assetCondition->update($request->validated());

        return to_route('asset-conditions.index')->with('success', 'Kondisi aset berhasil diperbarui.');
    }
}
