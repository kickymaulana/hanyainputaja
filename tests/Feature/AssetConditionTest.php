<?php

namespace Tests\Feature;

use App\Models\AssetCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetConditionTest extends TestCase
{
    use RefreshDatabase;

    public function test_condition_can_be_listed_created_and_updated(): void
    {
        AssetCondition::factory()->create(['name' => 'BAIK']);
        $this->get('/asset-conditions')->assertOk()->assertInertia(fn ($page) => $page->component('AssetConditions/Index')->has('conditions', 1));
        $this->post('/asset-conditions', ['name' => 'RUSAK RINGAN'])->assertRedirect('/asset-conditions');
        $condition = AssetCondition::query()->where('name', 'RUSAK RINGAN')->firstOrFail();
        $this->put('/asset-conditions/'.$condition->id, ['name' => 'RUSAK BERAT', 'is_active' => false])->assertRedirect('/asset-conditions');
        $this->assertDatabaseHas('asset_conditions', ['id' => $condition->id, 'name' => 'RUSAK BERAT', 'is_active' => 0]);
    }

    public function test_condition_name_must_be_unique(): void
    {
        AssetCondition::factory()->create(['name' => 'BAIK']);
        $this->from('/asset-conditions/create')->post('/asset-conditions', ['name' => 'BAIK'])->assertRedirect('/asset-conditions/create')->assertSessionHasErrors('name');
    }
}
