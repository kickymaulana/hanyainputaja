<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use App\Models\Memory;
use App\Models\Position;
use App\Models\Processor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AssetController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->string('search'));

        return Inertia::render('Assets/Index', [
            'assets' => Asset::query()
                ->with(['category:id,name', 'location:id,name', 'department:id,name', 'brand:id,name', 'processor:id,name', 'memory:id,name', 'position:id,name', 'condition:id,name'])
                ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                    $query->where('description', 'like', "%{$search}%")
                        ->orWhere('user_name', 'like', "%{$search}%")
                        ->orWhere('serial_number', 'like', "%{$search}%");
                }))
                ->latest()
                ->get(),
            'filters' => ['search' => $search],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Assets/Create', $this->masterOptions());
    }

    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $asset = Asset::query()->create($request->validated());

        return to_route('assets.show', $asset)->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Asset $asset): Response
    {
        return Inertia::render('Assets/Show', [
            'asset' => $asset->load(['category', 'location', 'department', 'brand', 'processor', 'memory', 'position', 'condition']),
        ]);
    }

    public function edit(Asset $asset): Response
    {
        return Inertia::render('Assets/Edit', [...$this->masterOptions(), 'asset' => $asset]);
    }

    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        $asset->update($request->validated());

        return to_route('assets.show', $asset)->with('success', 'Aset berhasil diperbarui.');
    }

    /** @return array<string, mixed> */
    private function masterOptions(): array
    {
        return [
            'categories' => Category::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'locations' => Location::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'departments' => Department::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'brands' => Brand::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'processors' => Processor::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'memories' => Memory::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'positions' => Position::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
            'conditions' => AssetCondition::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']),
        ];
    }
}
