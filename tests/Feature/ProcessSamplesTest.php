<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessSamplesTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_process_samples(): void
    {
        $response = $this->post('api/process');

        dd($response);
        $response->assertOk();
    }
}
