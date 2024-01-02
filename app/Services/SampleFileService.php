<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SampleFileService implements SampleFileProcessor
{

    public function getSamplesList(): \Illuminate\Support\Collection
    {
        return Http::get(config('api.lab_url') . '/samples')->collect();
    }

    /**
     * @return string[]
     */
    public function readSampleFile(string $file): array
    {
        $file = file_get_contents($file);
        if ($file === false) {
            throw new \RuntimeException('Could not read file');
        }
        return explode("\n", $file);
    }
}
