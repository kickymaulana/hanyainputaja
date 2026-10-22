<?php

namespace Database\Factories;

use App\Models\Factory as FactoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryFactory extends Factory
{
    protected $model = FactoryModel::class;

    public function definition(): array
    {
        return ['name' => fake()->unique()->company(), 'description' => fake()->optional()->sentence(), 'is_active' => true];
    }
}
