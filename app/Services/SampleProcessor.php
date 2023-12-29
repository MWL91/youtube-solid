<?php

namespace App\Services;

interface SampleProcessor
{
    /** @throws \RuntimeException */
    public function handle(): void;
}
