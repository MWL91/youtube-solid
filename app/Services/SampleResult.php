<?php

namespace App\Services;

interface SampleResult
{
    public function getResult(array $sampleEntry): bool;
}
