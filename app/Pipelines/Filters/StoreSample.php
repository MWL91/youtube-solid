<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;
use App\Pipelines\LaravelQueueFilter;
use App\Repositories\SamplesRepository;
use Ramsey\Uuid\UuidInterface;

class StoreSample extends LaravelQueueFilter
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly SamplesRepository $samplesRepository
    )
    {
    }

    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $sample->setStorageId($this->id);
        $this->samplesRepository->createSample($sample);

        return $sample;
    }
}
