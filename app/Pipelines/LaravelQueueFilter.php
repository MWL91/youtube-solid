<?php

namespace App\Pipelines;

use App\Entities\SampleEntry;
use App\Models\PipelineProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Ramsey\Uuid\UuidInterface;

abstract class LaravelQueueFilter implements PipeShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable;

    private string $_processId;

    public function setProcessId(UuidInterface $processId): void
    {
        $this->_processId = $processId->toString();
    }

    public function handle(): void
    {
        $progress = PipelineProgress::find($this->getProcessId());
        $sampleEntry = SampleEntry::fromArray($progress->payload);

        $this->__invoke($sampleEntry);

        $progress->payload = $sampleEntry->toArray();
        $progress->save();
    }

    protected function getProcessId(): string
    {
        return $this->_processId;
    }
}
