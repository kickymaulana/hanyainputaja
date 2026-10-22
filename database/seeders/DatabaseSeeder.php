<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            LocationSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            AssetConditionSeeder::class,
            BrandSeeder::class,
            ProcessorSeeder::class,
            MemorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
