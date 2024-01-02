<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;
use App\Pipelines\LaravelQueueFilter;

class DiscoverResult extends LaravelQueueFilter
{
    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $sample->setResult($sample->getAlphaScore() >= $sample->getBetaScore());
        return $sample;
    }
}
