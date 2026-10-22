<?php

namespace Database\Seeders;

use App\Models\Factory;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Dalu 1', 'Dalu 2', 'Kim'] as $name) {
            Factory::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
