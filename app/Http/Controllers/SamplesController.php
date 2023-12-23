<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SamplesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse([
            [
                'id' => 1,
                'name' => 'Sample 1',
                'file' => url('storage/research_data_1.csv')
            ],
            [
                'id' => 2,
                'name' => 'Sample 2',
                'file' => url('storage/research_data_2.csv')
            ]
        ]);
    }
}
