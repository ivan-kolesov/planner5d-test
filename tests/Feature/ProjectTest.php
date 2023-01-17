<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function test_ProjectList(): void
    {
        $response = $this->get('/api/list');
        $response
            ->assertJson(fn(AssertableJson $json) => $json->has('data', fn(AssertableJson $json) => $json->has('0.id')
                ->has('0.title')
                ->has('0.order_pos')
                ->has('0.canvas_link')
                ->has('0.hits')
                ->etc()
            ));
    }

    public function test_ProjectGet(): void
    {
        $response = $this->get('/api/project/1');
        $response
            ->assertJson(fn(AssertableJson $json) => $json->has('id')
                ->has('title')
                ->has('order_pos')
                ->has('canvas_link')
                ->has('hits')
                ->etc()
            );
    }

    public function test_ProjectNonExists(): void
    {
        $response = $this->get('/api/project/100000');
        $response->assertStatus(404);
    }
}
