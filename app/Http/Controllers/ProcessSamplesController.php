<?php

namespace App\Http\Controllers;

use App\Services\SampleProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProcessSamplesController extends Controller
{
    public function __construct(private SampleProcessor $processor)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->processor->handle();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        return new JsonResponse(['success' => true]);
    }
}
