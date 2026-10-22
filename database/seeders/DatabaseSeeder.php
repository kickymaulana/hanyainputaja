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
            FactorySeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            AssetStatusSeeder::class,
            AssetConditionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
