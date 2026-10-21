<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_master_data_hub(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get('/master')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('MasterData/Index')
                ->has('counts.categories')
                ->has('counts.locations')
                ->has('counts.departments')
                ->has('counts.statuses')
                ->has('counts.conditions'));
    }

    public function test_non_admin_cannot_view_master_data_hub(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'operator']))
            ->get('/master')
            ->assertForbidden();
    }
}
