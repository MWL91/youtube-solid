<?php

namespace App\Services;

use App\Entities\SampleEntry;
use App\Repositories\SamplesRepository;
use Illuminate\Support\Facades\Http;

class DeepAnalyticsService implements DeepAnalyticsProcessor
{
    public function __construct(private SamplesRepository $repository)
    {

    }

    /**
     * @param array $sampleEntry
     * @param mixed $sample
     * @return void
     */
    public function deepAnalitycs(SampleEntry $sampleEntry): void
    {
        if (Http::post(config('api.lab_url') . '/deep_analitics', $sampleEntry)->ok()) {
            $this->repository->setDeepAnalytics($sampleEntry->getStorageId(), true);
        }
    }
}
