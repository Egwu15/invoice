<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AliveTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_app_runs(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
