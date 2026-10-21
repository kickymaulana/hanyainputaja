<?php

namespace Database\Factories;

use App\Models\AssetCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AssetCondition> */
class AssetConditionFactory extends Factory
{
    protected $model = AssetCondition::class;

    public function definition(): array
    {
        return ['name' => fake()->unique()->words(2, true), 'is_active' => true];
    }
}
