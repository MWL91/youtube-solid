<?php

namespace App\Services;

interface SamplesGraph
{
    public function getBvsGraph(array $sampleEntry, string $name, int $rowKey): string;
    public function getGraph(array $sampleEntry, string $name, int $rowKey): string;
}
