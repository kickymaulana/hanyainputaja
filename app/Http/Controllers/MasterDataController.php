<?php

namespace App\Http\Controllers;

use App\Models\AssetCondition;
use App\Models\AssetStatus;
use App\Models\Category;
use App\Models\Department;
use App\Models\Factory;
use App\Models\Location;
use App\Models\Position;
use Inertia\Inertia;
use Inertia\Response;

class MasterDataController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('MasterData/Index', [
            'counts' => [
                'categories' => Category::query()->count(),
                'locations' => Location::query()->count(),
                'factories' => Factory::query()->count(),
                'departments' => Department::query()->count(),
                'positions' => Position::query()->count(),
                'statuses' => AssetStatus::query()->count(),
                'conditions' => AssetCondition::query()->count(),
            ],
        ]);
    }
}
