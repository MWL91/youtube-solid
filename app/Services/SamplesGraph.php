<?php

namespace App\Services;

use App\Entities\SampleEntry;

interface SamplesGraph
{
    public function getBvsGraph(SampleEntry $sample): string;
    public function getGraph(SampleEntry $sample): string;
}
