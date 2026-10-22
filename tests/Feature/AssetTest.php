<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use App\Models\Memory;
use App\Models\Processor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    public function test_asset_can_be_created_with_hardware_masters_and_uppercase_text(): void
    {
        $data = $this->validAssetData();
        $response = $this->post('/assets', $data);
        $asset = Asset::query()->firstOrFail();

        $response->assertRedirect('/assets/'.$asset->id);
        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'brand_id' => $data['brand_id'],
            'processor_id' => $data['processor_id'],
            'memory_id' => $data['memory_id'],
            'description' => 'SERVER BACKUP',
            'user_name' => 'MULIYONO',
            'serial_number' => 'SN-001',
        ]);
        $this->get('/assets/'.$asset->id)->assertOk()->assertInertia(fn ($page) => $page
            ->component('Assets/Show')
            ->where('asset.brand.name', 'ACER')
            ->where('asset.processor.name', 'INTEL CORE I5')
            ->where('asset.memory.name', '16 GB'));
    }

    public function test_processor_and_memory_are_optional(): void
    {
        $data = $this->validAssetData();
        $data['processor_id'] = null;
        $data['memory_id'] = null;

        $this->post('/assets', $data)->assertRedirect();
        $this->assertDatabaseHas('assets', ['processor_id' => null, 'memory_id' => null]);
    }

    public function test_asset_create_page_receives_active_hardware_options(): void
    {
        Brand::factory()->create(['name' => 'ACER']);
        Brand::factory()->create(['name' => 'INACTIVE', 'is_active' => false]);
        Processor::factory()->create(['name' => 'INTEL CORE I5']);
        Memory::factory()->create(['name' => '16 GB']);

        $this->get('/assets/create')->assertInertia(fn ($page) => $page
            ->component('Assets/Create')
            ->has('brands', 1)
            ->has('processors', 1)
            ->has('memories', 1));
    }

    public function test_assets_can_be_searched_by_serial_number(): void
    {
        Asset::factory()->create(['serial_number' => 'SN-SERVER', 'description' => 'SERVER BACKUP']);
        Asset::factory()->create(['serial_number' => 'SN-PRINTER', 'description' => 'PRINTER']);

        $this->get('/assets?search=SERVER')->assertInertia(fn ($page) => $page->has('assets', 1)->where('assets.0.serial_number', 'SN-SERVER'));
    }

    public function test_asset_can_be_updated(): void
    {
        $asset = Asset::factory()->create();
        $data = $this->validAssetData();
        $data['description'] = 'updated asset';

        $this->put('/assets/'.$asset->id, $data)->assertRedirect('/assets/'.$asset->id);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'description' => 'UPDATED ASSET']);
    }

    /** @return array<string, mixed> */
    private function validAssetData(): array
    {
        return [
            'category_id' => Category::factory()->create()->id,
            'description' => 'server backup',
            'location_id' => Location::factory()->create()->id,
            'department_id' => Department::factory()->create()->id,
            'brand_id' => Brand::factory()->create(['name' => 'ACER'])->id,
            'processor_id' => Processor::factory()->create(['name' => 'INTEL CORE I5'])->id,
            'memory_id' => Memory::factory()->create(['name' => '16 GB'])->id,
            'user_name' => 'Muliyono',

            'asset_condition_id' => AssetCondition::factory()->create()->id,
            'serial_number' => 'sn-001',
            'notes' => 'ready',
        ];
    }
}
