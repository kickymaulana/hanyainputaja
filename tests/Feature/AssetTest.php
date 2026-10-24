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
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_assets_can_be_filtered_by_category_and_condition(): void
    {
        $category = Category::factory()->create(['name' => 'KOMPUTER']);
        $condition = AssetCondition::factory()->create(['name' => 'BAIK']);
        $matching = Asset::factory()->create(['category_id' => $category->id, 'asset_condition_id' => $condition->id]);
        Asset::factory()->create();

        $this->get('/assets?category_id='.$category->id.'&asset_condition_id='.$condition->id)
            ->assertInertia(fn ($page) => $page
                ->has('assets', 1)
                ->where('assets.0.id', $matching->id)
                ->where('filters.category_id', $category->id)
                ->where('filters.asset_condition_id', $condition->id));
    }

    public function test_assets_can_be_filtered_by_location_and_department(): void
    {
        $location = Location::factory()->create(['name' => 'KANTOR PUSAT']);
        $department = Department::factory()->create(['name' => 'TEKNOLOGI INFORMASI']);
        $matching = Asset::factory()->create([
            'location_id' => $location->id,
            'department_id' => $department->id,
        ]);
        Asset::factory()->create();

        $this->get('/assets?location_id='.$location->id.'&department_id='.$department->id)
            ->assertInertia(fn ($page) => $page
                ->has('assets', 1)
                ->where('assets.0.id', $matching->id)
                ->where('filters.location_id', $location->id)
                ->where('filters.department_id', $department->id)
                ->has('locations')
                ->has('departments'));
    }

    public function test_asset_can_be_updated(): void
    {
        $asset = Asset::factory()->create();
        $data = $this->validAssetData();
        $data['description'] = 'updated asset';

        $this->put('/assets/'.$asset->id, $data)->assertRedirect('/assets/'.$asset->id);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'description' => 'UPDATED ASSET']);
    }

    public function test_asset_photo_is_stored_on_s3_disk(): void
    {
        Storage::fake('s3');
        $data = $this->validAssetData();
        $data['photo'] = UploadedFile::fake()->image('asset.jpg', 1200, 800);

        $this->post('/assets', $data)->assertRedirect();
        $asset = Asset::query()->firstOrFail();

        $this->assertNotNull($asset->photo_path);
        Storage::disk('s3')->assertExists($asset->photo_path);
    }

    public function test_admin_can_delete_an_asset(): void
    {
        $asset = Asset::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->delete('/assets/'.$asset->id)
            ->assertRedirect('/assets')
            ->assertSessionHas('success', 'Aset berhasil dihapus.');

        $this->assertDatabaseMissing('assets', ['id' => $asset->id]);
    }

    public function test_viewer_cannot_delete_an_asset(): void
    {
        $asset = Asset::factory()->create();
        $viewer = User::factory()->create(['role' => 'viewer']);

        $this->actingAs($viewer)->delete('/assets/'.$asset->id)->assertForbidden();
        $this->assertDatabaseHas('assets', ['id' => $asset->id]);
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
