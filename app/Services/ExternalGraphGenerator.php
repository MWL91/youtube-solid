<?php

namespace App\Services;

use App\Entities\SampleEntry;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ExternalGraphGenerator implements SamplesGraph
{

    /**
     * @param array $sampleEntry
     * @param $name
     * @param int|string $rowKey
     * @return string
     */
    public function getBvsGraph(SampleEntry $sample): string
    {
        $sampleEntry = $sample->getValues();
        $name = $sample->getName();
        $graphBvsImage = Http::post(config('api.lab_url') . '/graph-bvs', $sampleEntry)->body();
        $fileBvsName = $name . '-' . uniqid() . '-bvs.png';
        Storage::disk('public')->put($fileBvsName, $graphBvsImage);
        return $fileBvsName;
    }

    /**
     * @param array $sampleEntry
     * @param $name
     * @param int|string $rowKey
     * @return string
     */
    public function getGraph(SampleEntry $sample): string
    {
        $sampleEntry = $sample->getValues();
        $name = $sample->getName();
        $graphImage = Http::post(config('api.lab_url') . '/graph', $sampleEntry)->body();
        $fileName = $name . '-' . uniqid() . '-standard.png';
        Storage::disk('public')->put($fileName, $graphImage);
        return $fileName;
    }
}
