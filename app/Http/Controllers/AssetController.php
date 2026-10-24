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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AssetController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->string('search'));
        $categoryId = $request->integer('category_id') ?: null;
        $conditionId = $request->integer('asset_condition_id') ?: null;

        return Inertia::render('Assets/Index', [
            'assets' => Asset::query()
                ->with(['category:id,name', 'location:id,name', 'department:id,name', 'brand:id,name', 'processor:id,name', 'memory:id,name', 'position:id,name', 'condition:id,name'])
                ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                    $query->where('description', 'like', "%{$search}%")
                        ->orWhere('user_name', 'like', "%{$search}%")
                        ->orWhere('serial_number', 'like', "%{$search}%");
                }))
                ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
                ->when($conditionId, fn ($query) => $query->where('asset_condition_id', $conditionId))
                ->latest()
                ->get(),
            'filters' => ['search' => $search, 'category_id' => $categoryId, 'asset_condition_id' => $conditionId],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Assets/Create', $this->masterOptions());
    }

    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['photo']);
        $asset = Asset::query()->create($validated);

        if ($request->hasFile('photo')) {
            $asset->update(['photo_path' => $this->storePhoto($request)]);
        }

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
        $validated = $request->validated();
        unset($validated['photo']);
        $asset->update($validated);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($asset->photo_path);
            $asset->update(['photo_path' => $this->storePhoto($request)]);
        }

        return to_route('assets.show', $asset)->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $this->deletePhoto($asset->photo_path);
        $asset->delete();

        return to_route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }

    public function photo(Asset $asset): mixed
    {
        abort_unless($asset->photo_path, 404);

        $disk = Storage::disk('s3');
        abort_unless($disk->exists($asset->photo_path), 404);

        return response($disk->get($asset->photo_path), 200, [
            'Content-Type' => $disk->mimeType($asset->photo_path) ?: 'image/jpeg',
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    private function storePhoto(StoreAssetRequest|UpdateAssetRequest $request): string
    {
        return $request->file('photo')->storeAs('asset-photos', Str::uuid().'.'.$request->file('photo')->extension(), 's3');
    }

    private function deletePhoto(?string $path): void
    {
        if ($path) {
            Storage::disk('s3')->delete($path);
        }
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
