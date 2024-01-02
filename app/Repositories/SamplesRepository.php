<?php

namespace App\Repositories;

use App\Entities\SampleEntry;

interface SamplesRepository
{
    public function createSample(SampleEntry $sample): void;

    public function setDeepAnalytics(\Ramsey\Uuid\UuidInterface $id, bool $valid): void;
}
