<?php

namespace App\Pipelines;

use App\Entities\SampleEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Queue\InteractsWithQueue;

class LaravelQueuePipeline implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private array $stages = [
    ];
    private SampleEntry $payload;

    public function __construct(callable ...$stages)
    {
        $this->stages = $stages;
    }

    public function pipe(callable $stage): self
    {
        $this->stages[] = ($stage);
        return $this;
    }

    public function process(mixed $payload): void
    {
        $this->payload = ($payload);
        $this->dispatch();
    }

    public function handle(): void
    {
        if($this->stages === []) {
            return;
        }

        $stage = array_shift($this->stages);
        $stage($this->payload);

        $this->dispatch();
    }

    /**
     * @return void
     */
    private function dispatch(): void
    {
        app(Dispatcher::class)->dispatch($this);
    }
}
