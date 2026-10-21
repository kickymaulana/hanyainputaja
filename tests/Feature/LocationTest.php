<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_locations_can_be_listed(): void
    {
        Location::factory()->create(['name' => 'OFFICE']);

        $response = $this->get('/locations');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Locations/Index')
            ->has('locations', 1)
        );
    }

    public function test_location_can_be_created(): void
    {
        $response = $this->post('/locations', [
            'name' => 'GUDANG',
            'description' => 'Area penyimpanan',
        ]);

        $response->assertRedirect('/locations');
        $this->assertDatabaseHas('locations', [
            'name' => 'GUDANG',
            'description' => 'Area penyimpanan',
            'is_active' => 1,
        ]);
    }

    public function test_location_name_must_be_unique(): void
    {
        Location::factory()->create(['name' => 'OFFICE']);

        $response = $this->from('/locations/create')->post('/locations', [
            'name' => 'OFFICE',
        ]);

        $response->assertRedirect('/locations/create');
        $response->assertSessionHasErrors('name');
    }

    public function test_location_can_be_updated_and_deactivated(): void
    {
        $location = Location::factory()->create(['name' => 'GUDANG']);

        $response = $this->put('/locations/'.$location->id, [
            'name' => 'GUDANG UTAMA',
            'description' => 'Gudang utama pabrik',
            'is_active' => false,
        ]);

        $response->assertRedirect('/locations');
        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'GUDANG UTAMA',
            'is_active' => 0,
        ]);
    }
}
