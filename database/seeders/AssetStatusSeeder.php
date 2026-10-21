<?php

namespace Database\Seeders;

use App\Models\AssetStatus;
use Illuminate\Database\Seeder;

class AssetStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Digunakan', 'Tersedia', 'Dipinjamkan', 'Dalam Perbaikan', 'Tidak Digunakan', 'Dihapuskan'] as $name) {
            AssetStatus::query()->updateOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
