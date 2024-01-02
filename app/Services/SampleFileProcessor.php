<?php

namespace App\Services;

interface SampleFileProcessor
{
    public function getSamplesList(): \Illuminate\Support\Collection;
    public function readSampleFile(string $file): array;
}
