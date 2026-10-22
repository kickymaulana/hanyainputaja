<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'user' => request()->user()->only(['name', 'role']),
            'summary' => ['total' => Asset::query()->count()],
        ]);
    }
}
