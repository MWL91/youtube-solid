<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeepAnalyticsService implements DeepAnalyticsProcessor
{

    /**
     * @param array $sampleEntry
     * @param mixed $sample
     * @return void
     */
    public function deepAnalitycs(array $sampleEntry, mixed $sample): void
    {
        if (Http::post(config('api.lab_url') . '/deep_analitics', $sampleEntry)->ok()) {
            $sample->deep_analitics = true;
        }
    }
}
