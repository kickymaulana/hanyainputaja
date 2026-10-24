<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetCondition;
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
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get('/')->assertOk()->assertSee('id="app"', false);
    }

    public function test_dashboard_shows_total_asset_summary(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        Asset::factory()->count(3)->create();

        $this->actingAs($user)->get('/')->assertInertia(fn ($page) => $page->component('Dashboard')
            ->where('summary.total', 3)
            ->where('summary.categories', 3)
            ->where('summary.locations', 3)
            ->where('summary.departments', 3)
            ->has('conditionBreakdown', 3)
            ->has('categoryBreakdown', 3));
    }

    public function test_dashboard_groups_assets_by_condition_and_category(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create(['name' => 'KOMPUTER']);
        $condition = AssetCondition::factory()->create(['name' => 'BAIK']);
        $location = Location::factory()->create();
        $department = Department::factory()->create();
        Asset::factory()->count(2)->create([
            'category_id' => $category->id,
            'asset_condition_id' => $condition->id,
            'location_id' => $location->id,
            'department_id' => $department->id,
        ]);

        $this->actingAs($user)->get('/')->assertInertia(fn ($page) => $page
            ->where('conditionBreakdown.0.name', 'BAIK')
            ->where('conditionBreakdown.0.total', 2)
            ->where('categoryBreakdown.0.name', 'KOMPUTER')
            ->where('categoryBreakdown.0.total', 2));
    }
}
