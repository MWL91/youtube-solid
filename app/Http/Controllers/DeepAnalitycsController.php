<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeepAnalitycsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // mock here, but consuming data for 10s...
        sleep(10);

        return response()->json([
            'success' => true
        ]);
    }
}
