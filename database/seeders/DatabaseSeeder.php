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
            AssetStatusSeeder::class,
            AssetConditionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
