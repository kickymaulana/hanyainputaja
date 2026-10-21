<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'OFFICE', 'description' => 'Area perkantoran.'],
            ['name' => 'GUDANG', 'description' => 'Area penyimpanan barang dan aset.'],
        ] as $location) {
            Location::query()->updateOrCreate(
                ['name' => $location['name']],
                [...$location, 'is_active' => true],
            );
        }
    }
}
