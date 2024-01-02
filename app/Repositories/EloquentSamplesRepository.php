<?php

namespace App\Repositories;

use App\Entities\SampleEntry;
use App\Models\Sample;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EloquentSamplesRepository implements SamplesRepository
{

    public function createSample(SampleEntry $sample): void
    {
        Sample::create([
            'id' => $sample->getStorageId()->toString(),
            'sample_id' => $sample->getId(),
            'name' => $sample->getName(),
            'data' => $sample->getValues(),
            'result' => $sample->getResult(),
            'chart_standard_url' => $sample->getGraphFileName(),
            'chart_bvs_url' => $sample->getGraphBvsFileName(),
            'rate_1' => $sample->getAlphaScore(),
            'rate_2' => $sample->getBetaScore(),
            'rate_3' => $sample->getGammaScore(),
            'rate_4' => $sample->getDeltaScore(),
            'rate_5' => $sample->getEpsilonScore(),
        ]);
    }

    public function setDeepAnalytics(\Ramsey\Uuid\UuidInterface $id, bool $valid): void
    {
        Sample::where('id', $id->toString())->update(['deep_analytics' => $valid]);
    }
}
