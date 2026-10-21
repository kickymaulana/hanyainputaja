<?php

namespace Tests\Feature;

use App\Models\AssetStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_can_be_listed_created_and_updated(): void
    {
        AssetStatus::factory()->create(['name' => 'Digunakan']);

        $this->get('/asset-statuses')->assertOk()->assertInertia(fn ($page) => $page->component('AssetStatuses/Index')->has('statuses', 1));
        $this->post('/asset-statuses', ['name' => 'Tersedia'])->assertRedirect('/asset-statuses');
        $status = AssetStatus::query()->where('name', 'Tersedia')->firstOrFail();
        $this->put('/asset-statuses/'.$status->id, ['name' => 'Siap Digunakan', 'is_active' => false])->assertRedirect('/asset-statuses');
        $this->assertDatabaseHas('asset_statuses', ['id' => $status->id, 'name' => 'Siap Digunakan', 'is_active' => 0]);
    }

    public function test_status_name_must_be_unique(): void
    {
        AssetStatus::factory()->create(['name' => 'Digunakan']);
        $this->from('/asset-statuses/create')->post('/asset-statuses', ['name' => 'Digunakan'])->assertRedirect('/asset-statuses/create')->assertSessionHasErrors('name');
    }
}
