<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\AssetStatus;
use App\Models\Category;
use App\Models\Department;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_route_is_available_for_authenticated_user(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get('/')
            ->assertOk()
            ->assertSee('id="app"', false);
    }

    public function test_dashboard_shows_real_asset_summary(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $location = Location::factory()->create();
        $department = Department::factory()->create();
        $condition = AssetCondition::factory()->create();
        $used = AssetStatus::factory()->create(['name' => 'Digunakan']);
        $available = AssetStatus::factory()->create(['name' => 'Tersedia']);
        $repair = AssetStatus::factory()->create(['name' => 'Dalam Perbaikan']);

        Asset::factory()->create(['asset_code' => 'AST-1', 'category_id' => $category->id, 'location_id' => $location->id, 'department_id' => $department->id, 'asset_condition_id' => $condition->id, 'asset_status_id' => $used->id]);
        Asset::factory()->create(['asset_code' => 'AST-2', 'category_id' => $category->id, 'location_id' => $location->id, 'department_id' => $department->id, 'asset_condition_id' => $condition->id, 'asset_status_id' => $available->id]);
        Asset::factory()->create(['asset_code' => 'AST-3', 'category_id' => $category->id, 'location_id' => $location->id, 'department_id' => $department->id, 'asset_condition_id' => $condition->id, 'asset_status_id' => $repair->id]);

        $this->actingAs($user)->get('/')->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->where('summary.total', 3)
            ->where('summary.used', 1)
            ->where('summary.available', 1)
            ->where('summary.repair', 1));
    }
}
