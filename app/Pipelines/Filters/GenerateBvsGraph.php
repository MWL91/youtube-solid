<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;
use App\Services\SamplesGraph;

class GenerateBvsGraph
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
