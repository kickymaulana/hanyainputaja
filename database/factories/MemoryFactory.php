<?php

namespace Database\Factories;

use App\Models\Memory;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Memory> */
class MemoryFactory extends Factory
{
    protected $model = Memory::class;

    public function definition(): array
    {
        return ['name' => fake()->unique()->numberBetween(2, 128).' GB', 'is_active' => true];
    }
}
