<?php

namespace Database\Seeders;

use App\Models\Processor;
use Illuminate\Database\Seeder;

class ProcessorSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['INTEL CORE I3', 'INTEL CORE I5', 'INTEL CORE I7', 'AMD RYZEN 5'] as $name) {
            Processor::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
