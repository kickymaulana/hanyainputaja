<?php

namespace Database\Seeders;

use App\Models\Memory;
use Illuminate\Database\Seeder;

class MemorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['4 GB', '8 GB', '16 GB', '32 GB'] as $name) {
            Memory::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
