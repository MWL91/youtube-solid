<?php

namespace App\Pipelines;

use Illuminate\Contracts\Queue\ShouldQueue;
use Ramsey\Uuid\UuidInterface;

interface PipeShouldQueue extends ShouldQueue
{
    public function setProcessId(UuidInterface $processId);
}
