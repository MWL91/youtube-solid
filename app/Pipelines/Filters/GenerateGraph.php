<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;
use App\Services\SamplesGraph;

class GenerateGraph
{
    public function __construct(private readonly SamplesGraph $samplesGraphGenerator)
    {
    }

    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $graph = $this->samplesGraphGenerator->getGraph($sample);
        $sample->setGraphFileName($graph);

        return $sample;
    }
}
