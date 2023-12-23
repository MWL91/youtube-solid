<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GraphBvsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        // mock here, but consuming data for 1s...
        $chart = new \ImageCharts();
        $pie = $chart->cht('bvs')->chd('a:'.implode(',', $request->all()))->chs('500x500');
        $bin = $pie->toBinary();

        return new Response($bin, 200, [
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($bin)
        ]);
    }
}
