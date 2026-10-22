<?php

namespace Tests\Feature;

use App\Models\Processor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_processor_can_be_listed_created_and_updated(): void
    {
        Processor::factory()->create(['name' => 'INTEL CORE I3']);
        $this->get('/processors')->assertInertia(fn ($page) => $page->component('Processors/Index')->has('processors', 1));
        $this->post('/processors', ['name' => 'intel core i5'])->assertRedirect('/processors');
        $processor = Processor::query()->where('name', 'INTEL CORE I5')->firstOrFail();
        $this->put('/processors/'.$processor->id, ['name' => 'amd ryzen 5', 'is_active' => false])->assertRedirect('/processors');
        $this->assertDatabaseHas('processors', ['id' => $processor->id, 'name' => 'AMD RYZEN 5', 'is_active' => 0]);
    }
}
