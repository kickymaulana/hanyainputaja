<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProcessorRequest;
use App\Http\Requests\UpdateProcessorRequest;
use App\Models\Processor;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProcessorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Processors/Index', ['processors' => Processor::query()->orderBy('name')->get(['id', 'name', 'is_active'])]);
    }

    public function create(): Response
    {
        return Inertia::render('Processors/Create');
    }

    public function store(StoreProcessorRequest $request): RedirectResponse
    {
        Processor::query()->create($request->validated());

        return to_route('processors.index')->with('success', 'Processor berhasil ditambahkan.');
    }

    public function edit(Processor $processor): Response
    {
        return Inertia::render('Processors/Edit', ['processor' => $processor->only(['id', 'name', 'is_active'])]);
    }

    public function update(UpdateProcessorRequest $request, Processor $processor): RedirectResponse
    {
        $processor->update($request->validated());

        return to_route('processors.index')->with('success', 'Processor berhasil diperbarui.');
    }
}
