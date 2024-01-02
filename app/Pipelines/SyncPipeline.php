<?php

namespace App\Pipelines;

class SyncPipeline
{
    private array $stages = [];

    public function __construct(callable ...$stages)
    {
        $this->stages = $stages;
    }

    public function pipe(callable $stage): self
    {
        $this->stages[] = $stage;
        return $this;
    }

    public function process(mixed $payload): mixed
    {
        foreach ($this->stages as $stage) {
            $payload = $stage($payload);
        }

        return $payload;
    }
}
