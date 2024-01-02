<?php

namespace App\Services;

class GetResultService implements SampleResult
{

    /**
     * @param array $sampleEntry
     * @return bool
     */
    public function getResult(array $sampleEntry): bool
    {
        return $sampleEntry[0] >= $sampleEntry[1];
    }
}
