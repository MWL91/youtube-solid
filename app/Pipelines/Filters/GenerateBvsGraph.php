<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;
use App\Pipelines\LaravelQueueFilter;
use App\Services\SamplesGraph;

class GenerateBvsGraph extends LaravelQueueFilter
{
    public function __construct(private readonly SamplesGraph $samplesGraphGenerator)
    {
    }

    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $graph = $this->samplesGraphGenerator->getBvsGraph($sample);
        $sample->setGraphBvsFileName($graph);

        return $sample;
    }
}
