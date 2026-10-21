<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'IT', 'description' => 'Departemen teknologi informasi.'],
            ['name' => 'FQC', 'description' => 'Departemen final quality control.'],
            ['name' => 'CUCI CELUP', 'description' => 'Departemen cuci celup.'],
        ] as $department) {
            Department::query()->updateOrCreate(
                ['name' => $department['name']],
                [...$department, 'is_active' => true],
            );
        }
    }
}
