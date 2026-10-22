<?php

namespace Database\Factories;

use App\Models\Processor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Processor> */
class ProcessorFactory extends Factory
{
    protected $model = Processor::class;

    public function definition(): array
    {
        return ['name' => fake()->unique()->words(3, true), 'is_active' => true];
    }
}
