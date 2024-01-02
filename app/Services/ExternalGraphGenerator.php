<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ExternalGraphGenerator implements SamplesGraph
{

    /**
     * @param array $sampleEntry
     * @param $name
     * @param int|string $rowKey
     * @return string
     */
    public function getBvsGraph(array $sampleEntry, $name, int|string $rowKey): string
    {
        $graphBvsImage = Http::post(config('api.lab_url') . '/graph-bvs', $sampleEntry)->body();
        $fileBvsName = $name . '-' . $rowKey . '-bvs.png';
        Storage::disk('public')->put($fileBvsName, $graphBvsImage);
        return $fileBvsName;
    }

    /**
     * @param array $sampleEntry
     * @param $name
     * @param int|string $rowKey
     * @return string
     */
    public function getGraph(array $sampleEntry, $name, int|string $rowKey): string
    {
        $graphImage = Http::post(config('api.lab_url') . '/graph', $sampleEntry)->body();
        $fileName = $name . '-' . $rowKey . '-standard.png';
        Storage::disk('public')->put($fileName, $graphImage);
        return $fileName;
    }
}
