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

    public function __construct()
    {
    }

    public function pipe(callable $stage): self
    {
        $pipeline = clone $this;
        $pipeline->stages[] = ($stage::class);

        return $pipeline;
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

        $payload = ['1', 'b', 'd'];
        $stage = new (array_shift($this->stages))(...$payload);
        $stage($this->payload);

        $this->dispatch();
    }

    /**
     * @return void
     */
    private function dispatch(): void
    {
//        dump('!');
//        dump([$this, serialize($this)]);
        app(Dispatcher::class)->dispatch($this);
    }
}
