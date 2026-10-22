<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFactoryRequest;
use App\Http\Requests\UpdateFactoryRequest;
use App\Models\Factory;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FactoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Factories/Index', ['factories' => Factory::query()->orderBy('name')->get(['id', 'name', 'description', 'is_active'])]);
    }

    public function create(): Response
    {
        return Inertia::render('Factories/Create');
    }

    public function store(StoreFactoryRequest $request): RedirectResponse
    {
        Factory::query()->create($request->validated());

        return to_route('factories.index')->with('success', 'Pabrik berhasil ditambahkan.');
    }

    public function edit(Factory $factory): Response
    {
        return Inertia::render('Factories/Edit', ['factory' => $factory->only(['id', 'name', 'description', 'is_active'])]);
    }

    public function update(UpdateFactoryRequest $request, Factory $factory): RedirectResponse
    {
        $factory->update($request->validated());

        return to_route('factories.index')->with('success', 'Pabrik berhasil diperbarui.');
    }
}
