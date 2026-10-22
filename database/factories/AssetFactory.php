<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use App\Models\Memory;
use App\Models\Position;
use App\Models\Processor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Asset> */
class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'description' => fake()->sentence(),
            'location_id' => Location::factory(),
            'department_id' => Department::factory(),
            'brand_id' => Brand::factory(),
            'processor_id' => Processor::factory(),
            'memory_id' => Memory::factory(),
            'user_name' => fake()->name(),
            'position_id' => Position::factory(),
            'asset_condition_id' => AssetCondition::factory(),
            'serial_number' => fake()->optional()->bothify('SN-########'),
            'acquisition_date' => fake()->optional()->date(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
