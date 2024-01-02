<?php

namespace App\Pipelines\Filters;

use App\Entities\SampleEntry;

class SetSampleAttributes
{
    public function __construct(private string $rawData, private string $name, private string $id)
    {
    }

    public function __invoke(SampleEntry $sample): SampleEntry
    {
        $sample->setValues(explode(';', $this->rawData));
        $sample->setName($this->name);
        $sample->setId($this->id);
        return $sample;
    }
}
