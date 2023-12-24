<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Laravel\Pennant\Feature;

class SampleListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\View\View
    {
        if(Feature::active('new-view')) {
            $samples = Sample::paginate(10);
        } else {
            $samples = Sample::all();
        }

        if(Feature::active('new-view')) {
            return View::make('samples/new-index', [
                'samples' => $samples
            ]);
        }

        return View::make('samples/index', [
            'samples' => $samples
        ]);
    }
}
