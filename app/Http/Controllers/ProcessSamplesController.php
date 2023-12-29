<?php

namespace App\Http\Controllers;

use App\Services\SampleProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProcessSamplesController extends Controller
{

    /**
     * ProcessSamplesController constructor.
     */
    public function __construct(private SampleProcessor $processSampleService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            ($this->processSampleService)();
        } catch (\RuntimeException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(['success' => true]);
    }
}
