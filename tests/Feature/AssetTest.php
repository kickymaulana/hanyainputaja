<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\AssetStatus;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    public function test_asset_can_be_created_and_viewed(): void
    {
        $data = $this->validAssetData();

        $response = $this->post('/assets', $data);
        $asset = Asset::query()->firstOrFail();

        $response->assertRedirect('/assets/'.$asset->id);
        $this->get('/assets/'.$asset->id)
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Assets/Show')->where('asset.asset_code', 'AST-001'));
    }

    public function test_asset_code_must_be_unique(): void
    {
        Asset::factory()->create(['asset_code' => 'AST-001']);

        $this->from('/assets/create')->post('/assets', $this->validAssetData())
            ->assertRedirect('/assets/create')
            ->assertSessionHasErrors('asset_code');
    }

    public function test_assets_can_be_searched(): void
    {
        Asset::factory()->create(['asset_code' => 'AST-SERVER', 'description' => 'Server backup']);
        Asset::factory()->create(['asset_code' => 'AST-PRINTER', 'description' => 'Printer kantor']);

        $this->get('/assets?search=SERVER')
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('Assets/Index')->has('assets', 1)->where('assets.0.asset_code', 'AST-SERVER'));
    }

    public function test_asset_can_be_updated(): void
    {
        $asset = Asset::factory()->create(['asset_code' => 'AST-OLD']);
        $data = $this->validAssetData();
        $data['asset_code'] = 'AST-NEW';

        $this->put('/assets/'.$asset->id, $data)->assertRedirect('/assets/'.$asset->id);
        $this->assertDatabaseHas('assets', ['id' => $asset->id, 'asset_code' => 'AST-NEW']);
    }

    /** @return array<string, mixed> */
    private function validAssetData(): array
    {
        return [
            'asset_code' => 'AST-001',
            'category_id' => Category::factory()->create()->id,
            'description' => 'Intel i5 memory 16 GB untuk server backup',
            'location_id' => Location::factory()->create()->id,
            'department_id' => Department::factory()->create()->id,
            'user_name' => 'Muliyono',
            'user_position' => 'Manager',
            'asset_status_id' => AssetStatus::factory()->create()->id,
            'asset_condition_id' => AssetCondition::factory()->create()->id,
            'brand' => 'Rakitan',
        ];
    }
}
