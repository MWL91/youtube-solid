<?php

namespace App\Services;

use App\Entities\SampleEntry;
use App\Models\Sample;
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

        $samplesFn = function(SampleEntry $sample, callable $call): SampleEntry {
            $call($sample);
            return $sample;
        };

        foreach($samples as $sampleRow) {
            $rows = $this->sampleFileService->readSampleFile($sampleRow['file']);

            foreach($rows as $row) {
                (new SyncPipeline())
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setValues(explode(';', $row))))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setName($sampleRow['name'])))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setId($sampleRow['id'])))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setResult($sample->getAlphaScore() >= $sample->getBetaScore())))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setGraphFileName($this->samplesGraphGenerator->getGraph($sample))))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setGraphBvsFileName($this->samplesGraphGenerator->getBvsGraph($sample))))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $sample->setStorageId(Uuid::uuid4())))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $this->samplesRepository->createSample($sample)))
                    ->pipe(fn (SampleEntry $sample) => $samplesFn($sample, fn () => $this->deepAnalitycsService->deepAnalitycs($sample)))
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
