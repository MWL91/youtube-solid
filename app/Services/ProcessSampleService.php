<?php

namespace App\Services;

use App\Models\Sample;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ProcessSampleService implements SampleProcessor
{
    public function __invoke(): void
    {
        $samples = $this->getSamples();

        foreach($samples as $sample) {
            foreach($this->getResults($sample['file']) as $key => $result) {
                $this->processResult($result, $sample, $key);
            }
        }
    }

    private function processResult(string $rawResults, array $sample, int $rowKey): Sample
    {
        $data = explode(';', $rawResults);
        $result = $this->isPositive($data);

        $fileName = $this->generateGraph($data, $sample['name'], $rowKey);
        $fileBvsName = $this->generateBvsGraph($data, $sample['name'], $rowKey);
        $sample = $this->createSample($sample, $data, $result, $fileName, $fileBvsName);

        $this->performDeepAnalitics($data, $sample);
        return $sample;
    }

    private function getSamples(): \Illuminate\Support\Collection
    {
        $samples = Http::get(config('api.lab_url') . '/samples')->collect();
        return $samples;
    }

    private function getResults(string $fileName): array
    {
        $file = file_get_contents($fileName); // TODO !! This is slow for memory - we should use a stream instead
        if ($file === false) {
            throw new \RuntimeException('Could not read file');
        }

        return explode("\n", $file);
    }

    private function isPositive(array $result): bool
    {
        return $result[0] >= $result[1];
    }

    private function generateGraph(array $result, string $name, int $rowKey): string
    {
        $graphImage = Http::post(config('api.lab_url') . '/graph', $result)->body();
        $fileName = $name . '-' . $rowKey . '-standard.png';
        Storage::disk('public')->put($fileName, $graphImage);
        return $fileName;
    }

    private function generateBvsGraph(array $result, string $name, int $rowKey): string
    {
        $graphBvsImage = Http::post(config('api.lab_url') . '/graph-bvs', $result)->body();
        $fileBvsName = $name . '-' . $rowKey . '-bvs.png';
        Storage::disk('public')->put($fileBvsName, $graphBvsImage);
        return $fileBvsName;
    }

    private function createSample(array $sample, array $data, bool $result, string $fileName, string $fileBvsName): Sample
    {
        return Sample::create([
            'id' => Uuid::uuid4()->toString(),
            'sample_id' => $sample['id'],
            'name' => $sample['name'],
            'data' => $data,
            'result' => $result,
            'chart_standard_url' => $fileName,
            'chart_bvs_url' => $fileBvsName,
            'rate_1' => $data[0],
            'rate_2' => $data[1],
            'rate_3' => $data[2],
            'rate_4' => $data[3],
            'rate_5' => $data[4],
        ]);
    }

    private function performDeepAnalitics(array $data, mixed $sample): void
    {
        if (Http::post(config('api.lab_url') . '/deep_analitics', $data)->ok()) {
            $sample->deep_analitics = true;
        }
    }
}
