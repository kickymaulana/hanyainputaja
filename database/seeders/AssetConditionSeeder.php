<?php

namespace Database\Seeders;

use App\Models\AssetCondition;
use Illuminate\Database\Seeder;

class AssetConditionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $name) {
            AssetCondition::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
