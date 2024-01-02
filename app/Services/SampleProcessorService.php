<?php

namespace App\Services;

use App\Repositories\SamplesRepository;

class SampleProcessorService implements SampleProcessor
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

        foreach($samples as $sample) {
            $rows = $this->sampleFileService->readSampleFile($sample['file']);

            foreach($rows as $rowKey => $row) {
                $sampleEntry = $this->getSampleEntry($row);
                $result = $this->getResultService->getResult($sampleEntry);

                $fileName = $this->samplesGraphGenerator->getGraph($sampleEntry, $sample['name'], $rowKey);
                $fileBvsName = $this->samplesGraphGenerator->getBvsGraph($sampleEntry, $sample['name'], $rowKey);

                $sample = $this->samplesRepository->createSample($sample, $sampleEntry, $result, $fileName, $fileBvsName);
                $this->deepAnalitycsService->deepAnalitycs($sampleEntry, $sample);
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
