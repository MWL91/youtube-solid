<?php

namespace App\Pipelines;

use App\Entities\SampleEntry;
use App\Models\PipelineProgress;
use App\Pipelines\Filters\RemoveLaravelQueuePipelineProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Ramsey\Uuid\Uuid;

class LaravelQueuePipeline
{
    private array $stages = [
    ];
    private SampleEntry $payload;

    public function __construct(callable ...$stages)
    {
        $this->stages = $stages;
    }

    public function pipe(ShouldQueue $stage): self
    {
        $this->stages[] = ($stage);
        return $this;
    }

    public function process(Arrayable $payload): void
    {
        $processId = Uuid::uuid4();
        PipelineProgress::create([
            'id' => $processId,
            'payload' => $payload
        ]);

        array_map(fn (PipeShouldQueue $stage) => $stage->setProcessId($processId), $this->stages);
        Bus::chain($this->stages)->dispatch();
    }
}
