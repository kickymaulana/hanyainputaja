<?php

namespace Tests\Feature;

use App\Models\Asset;
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

        $this->actingAs($user)->get('/')->assertInertia(fn ($page) => $page->component('Dashboard')->where('summary.total', 3));
    }
}
