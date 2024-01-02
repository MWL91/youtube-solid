<?php

namespace App\Repositories;

use App\Models\Sample;
use Ramsey\Uuid\Uuid;

class EloquentSamplesRepository implements SamplesRepository
{

    /**
     * @param mixed $sample
     * @param array $sampleEntry
     * @param bool $result
     * @param string $fileName
     * @param string $fileBvsName
     * @return mixed
     */
    public function createSample(mixed $sample, array $sampleEntry, bool $result, string $fileName, string $fileBvsName)
    {
        $sample = Sample::create([
            'id' => Uuid::uuid4()->toString(),
            'sample_id' => $sample['id'],
            'name' => $sample['name'],
            'data' => $sampleEntry,
            'result' => $result,
            'chart_standard_url' => $fileName,
            'chart_bvs_url' => $fileBvsName,
            'rate_1' => $sampleEntry[0],
            'rate_2' => $sampleEntry[1],
            'rate_3' => $sampleEntry[2],
            'rate_4' => $sampleEntry[3],
            'rate_5' => $sampleEntry[4],
        ]);
        return $sample;
    }
}
