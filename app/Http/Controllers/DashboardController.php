<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $conditionBreakdown = Asset::query()
            ->select('asset_condition_id', DB::raw('count(*) as total'))
            ->with('condition:id,name')
            ->groupBy('asset_condition_id')
            ->get()
            ->map(fn (Asset $asset): array => ['id' => $asset->asset_condition_id, 'name' => $asset->condition->name, 'total' => (int) $asset->total])
            ->values();

        $categoryBreakdown = Asset::query()
            ->select('category_id', DB::raw('count(*) as total'))
            ->with('category:id,name')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get()
            ->map(fn (Asset $asset): array => ['id' => $asset->category_id, 'name' => $asset->category->name, 'total' => (int) $asset->total])
            ->values();

        return Inertia::render('Dashboard', [
            'user' => request()->user()->only(['name', 'role']),
            'summary' => [
                'total' => Asset::query()->count(),
                'categories' => Asset::query()->distinct('category_id')->count('category_id'),
                'locations' => Asset::query()->distinct('location_id')->count('location_id'),
                'departments' => Asset::query()->distinct('department_id')->count('department_id'),
            ],
            'conditionBreakdown' => $conditionBreakdown,
            'categoryBreakdown' => $categoryBreakdown,
        ]);
    }
}
