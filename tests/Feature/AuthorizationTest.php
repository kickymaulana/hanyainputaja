<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_viewer_can_view_assets_but_cannot_create_or_edit_them(): void
    {
        $viewer = User::factory()->create(['role' => 'viewer']);
        $asset = Asset::factory()->create();

        $this->actingAs($viewer)->get('/assets')->assertOk();
        $this->actingAs($viewer)->get('/assets/create')->assertForbidden();
        $this->actingAs($viewer)->get('/assets/'.$asset->id.'/edit')->assertForbidden();
    }

    public function test_operator_can_manage_assets_but_cannot_manage_master_data(): void
    {
        $operator = User::factory()->create(['role' => 'operator']);

        $this->actingAs($operator)->get('/assets/create')->assertOk();
        $this->actingAs($operator)->get('/categories')->assertForbidden();
    }

    public function test_admin_can_manage_master_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/categories')->assertOk();
    }
}
