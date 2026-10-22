<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoryRequest;
use App\Http\Requests\UpdateMemoryRequest;
use App\Models\Memory;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MemoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Memories/Index', ['memories' => Memory::query()->orderBy('name')->get(['id', 'name', 'is_active'])]);
    }

    public function create(): Response
    {
        return Inertia::render('Memories/Create');
    }

    public function store(StoreMemoryRequest $request): RedirectResponse
    {
        Memory::query()->create($request->validated());

        return to_route('memories.index')->with('success', 'Memory berhasil ditambahkan.');
    }

    public function edit(Memory $memory): Response
    {
        return Inertia::render('Memories/Edit', ['memory' => $memory->only(['id', 'name', 'is_active'])]);
    }

    public function update(UpdateMemoryRequest $request, Memory $memory): RedirectResponse
    {
        $memory->update($request->validated());

        return to_route('memories.index')->with('success', 'Memory berhasil diperbarui.');
    }
}
