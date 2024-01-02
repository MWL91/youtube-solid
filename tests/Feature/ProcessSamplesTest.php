<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sample;
use Tests\TestCase;

class ProcessSamplesTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_process_samples(): void
    {
        $response = $this->json('post','api/process');

        dd($response);
        $response->assertOk();
        $this->assertDatabaseHas('samples', [
            'name' => 'Sample 1',
            'rate_1' => 26,
            'rate_2' => 79,
            'rate_3' => 44,
            'rate_4' => 31,
            'rate_5' => 1,
            'deep_analytics' => true,
        ]);
    }
}
