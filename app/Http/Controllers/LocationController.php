<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Locations/Index', [
            'locations' => Location::query()
                ->orderBy('name')
                ->get(['id', 'name', 'description', 'is_active']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Locations/Create');
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        Location::query()->create($request->validated());

        return to_route('locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location): Response
    {
        return Inertia::render('Locations/Edit', [
            'location' => $location->only(['id', 'name', 'description', 'is_active']),
        ]);
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return to_route('locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }
}
