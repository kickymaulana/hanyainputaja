<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\AssetStatus;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Asset> */
class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'asset_code' => fake()->unique()->bothify('AST-####'),
            'category_id' => Category::factory(),
            'description' => fake()->sentence(),
            'location_id' => Location::factory(),
            'department_id' => Department::factory(),
            'user_name' => fake()->name(),
            'user_position' => fake()->jobTitle(),
            'asset_status_id' => AssetStatus::factory(),
            'asset_condition_id' => AssetCondition::factory(),
            'serial_number' => fake()->optional()->bothify('SN-########'),
            'brand' => fake()->optional()->company(),
            'acquisition_date' => fake()->optional()->date(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
