<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;

class DiscoverResult
{
    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $sample->setResult($sample->getAlphaScore() >= $sample->getBetaScore());
        return $sample;
    }
}
