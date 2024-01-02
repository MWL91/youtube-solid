<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;
use App\Pipelines\LaravelQueueFilter;
use App\Services\DeepAnalyticsProcessor;

class DeepAnalyze extends LaravelQueueFilter
{
    public function __construct(private readonly DeepAnalyticsProcessor $deepAnalyticsService)
    {
    }

    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $this->deepAnalyticsService->deepAnalitycs($sample);
        return $sample;
    }
}
