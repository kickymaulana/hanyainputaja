<?php

namespace Database\Factories;

use App\Models\AssetStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AssetStatus> */
class AssetStatusFactory extends Factory
{
    protected $model = AssetStatus::class;

    public function definition(): array
    {
        return ['name' => fake()->unique()->words(2, true), 'is_active' => true];
    }
}
