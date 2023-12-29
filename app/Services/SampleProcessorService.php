<?php

namespace App\Services;

use App\Models\Sample;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class SampleProcessorService implements SampleProcessor
{

    public function handle(): void
    {
        $samples = $this->getSamplesList();

        foreach($samples as $sample) {
            $rows = $this->readSampleFile($sample['file']);

            foreach($rows as $rowKey => $row) {
                $sampleEntry = $this->getSampleEntry($row);
                $result = $this->getResult($sampleEntry);

                $fileName = $this->getGraph($sampleEntry, $sample['name'], $rowKey);
                $fileBvsName = $this->getBvsGraph($sampleEntry, $sample['name'], $rowKey);

                $sample = $this->createSample($sample, $sampleEntry, $result, $fileName, $fileBvsName);
                $this->deepAnalitycs($sampleEntry, $sample);
            }
        }
    }

    private function getSamplesList(): \Illuminate\Support\Collection
    {
        return Http::get(config('api.lab_url') . '/samples')->collect();
    }

    /**
     * @return string[]
     */
    private function readSampleFile(string $file): array
    {
        $file = file_get_contents($file);
        if ($file === false) {
            throw new \RuntimeException('Could not read file');
        }
        return explode("\n", $file);
    }

    /**
     * @param string $row
     * @return string[]
     */
    private function getSampleEntry(string $row): array
    {
        return explode(';', $row);
    }

    /**
     * @param array $sampleEntry
     * @return bool
     */
    private function getResult(array $sampleEntry): bool
    {
        return $sampleEntry[0] >= $sampleEntry[1];
    }

    /**
     * @param array $sampleEntry
     * @param $name
     * @param int|string $rowKey
     * @return string
     */
    private function getGraph(array $sampleEntry, $name, int|string $rowKey): string
    {
        $graphImage = Http::post(config('api.lab_url') . '/graph', $sampleEntry)->body();
        $fileName = $name . '-' . $rowKey . '-standard.png';
        Storage::disk('public')->put($fileName, $graphImage);
        return $fileName;
    }

    /**
     * @param array $sampleEntry
     * @param $name
     * @param int|string $rowKey
     * @return string
     */
    private function getBvsGraph(array $sampleEntry, $name, int|string $rowKey): string
    {
        $graphBvsImage = Http::post(config('api.lab_url') . '/graph-bvs', $sampleEntry)->body();
        $fileBvsName = $name . '-' . $rowKey . '-bvs.png';
        Storage::disk('public')->put($fileBvsName, $graphBvsImage);
        return $fileBvsName;
    }

    /**
     * @param mixed $sample
     * @param array $sampleEntry
     * @param bool $result
     * @param string $fileName
     * @param string $fileBvsName
     * @return mixed
     */
    private function createSample(mixed $sample, array $sampleEntry, bool $result, string $fileName, string $fileBvsName)
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

    /**
     * @param array $sampleEntry
     * @param mixed $sample
     * @return void
     */
    private function deepAnalitycs(array $sampleEntry, mixed $sample): void
    {
        if (Http::post(config('api.lab_url') . '/deep_analitics', $sampleEntry)->ok()) {
            $sample->deep_analitics = true;
        }
    }
}
