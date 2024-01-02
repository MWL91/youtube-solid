<?php

namespace App\Services;

use App\Entities\SampleEntry;
use App\Models\Sample;
use App\Pipelines\Filters\DeepAnalyze;
use App\Pipelines\Filters\DiscoverResult;
use App\Pipelines\Filters\GenerateBvsGraph;
use App\Pipelines\Filters\GenerateGraph;
use App\Pipelines\Filters\SetSampleAttributes;
use App\Pipelines\Filters\StoreSample;
use App\Pipelines\SyncPipeline;
use App\Repositories\SamplesRepository;
use Ramsey\Uuid\Uuid;

class SamplePipelineService implements SampleProcessor
{
    public function __construct(
        private readonly DeepAnalyticsProcessor $deepAnalitycsService,
        private readonly SamplesRepository $samplesRepository,
        private readonly SamplesGraph $samplesGraphGenerator,
        private readonly SampleResult $getResultService,
        private readonly SampleFileProcessor $sampleFileService
    )
    {
    }

    public function handle(): void
    {
        $samples = $this->sampleFileService->getSamplesList();

        foreach($samples as $sampleRow) {
            $rows = $this->sampleFileService->readSampleFile($sampleRow['file']);

            foreach($rows as $row) {
                (new SyncPipeline())
                    ->pipe(new SetSampleAttributes($row, $sampleRow['name'], $sampleRow['id']))
                    ->pipe(new DiscoverResult())
                    ->pipe(new GenerateGraph($this->samplesGraphGenerator))
                    ->pipe(new GenerateBvsGraph($this->samplesGraphGenerator))
                    ->pipe(new StoreSample(Uuid::uuid4(), $this->samplesRepository))
                    ->pipe(new DeepAnalyze($this->deepAnalitycsService))
                    ->process(new SampleEntry());
            }
        }
    }

    /**
     * @param string $row
     * @return string[]
     */
    private function getSampleEntry(string $row): array
    {
        return explode(';', $row);
    }
}
