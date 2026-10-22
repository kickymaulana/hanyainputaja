<?php

namespace App\Http\Controllers;

use App\Models\AssetCondition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use App\Models\Memory;
use App\Models\Position;
use App\Models\Processor;
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
                'departments' => Department::query()->count(),
                'positions' => Position::query()->count(),
                'conditions' => AssetCondition::query()->count(),
                'brands' => Brand::query()->count(),
                'processors' => Processor::query()->count(),
                'memories' => Memory::query()->count(),
            ],
        ]);
    }
}
