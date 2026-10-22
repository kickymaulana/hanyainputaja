<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_can_be_listed_created_and_updated(): void
    {
        Brand::factory()->create(['name' => 'ACER']);
        $this->get('/brands')->assertInertia(fn ($page) => $page->component('Brands/Index')->has('brands', 1));
        $this->post('/brands', ['name' => 'asus'])->assertRedirect('/brands');
        $brand = Brand::query()->where('name', 'ASUS')->firstOrFail();
        $this->put('/brands/'.$brand->id, ['name' => 'dell', 'is_active' => false])->assertRedirect('/brands');
        $this->assertDatabaseHas('brands', ['id' => $brand->id, 'name' => 'DELL', 'is_active' => 0]);
    }

    public function test_brand_name_must_be_unique_after_normalization(): void
    {
        Brand::factory()->create(['name' => 'ACER']);
        $this->from('/brands/create')->post('/brands', ['name' => 'acer'])->assertSessionHasErrors('name');
    }
}
