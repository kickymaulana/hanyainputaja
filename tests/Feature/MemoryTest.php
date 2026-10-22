<?php

namespace Tests\Feature;

use App\Models\Memory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_memory_can_be_listed_created_and_updated(): void
    {
        Memory::factory()->create(['name' => '4 GB']);
        $this->get('/memories')->assertInertia(fn ($page) => $page->component('Memories/Index')->has('memories', 1));
        $this->post('/memories', ['name' => '8 gb'])->assertRedirect('/memories');
        $memory = Memory::query()->where('name', '8 GB')->firstOrFail();
        $this->put('/memories/'.$memory->id, ['name' => '16 gb', 'is_active' => false])->assertRedirect('/memories');
        $this->assertDatabaseHas('memories', ['id' => $memory->id, 'name' => '16 GB', 'is_active' => 0]);
    }
}
