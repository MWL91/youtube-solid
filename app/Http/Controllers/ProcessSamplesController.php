<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessSamplesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $samples = Http::get(config('api.lab_url') . '/samples')->collect();

        foreach($samples as $sample) {
            $file = file_get_contents($sample['file']);
            if($file === false) {
                return new JsonResponse(['error' => 'Could not read file'], 500);
            }

            $rows = explode("\n", $file);
            foreach($rows as $rowKey => $row) {
                $data = explode(';',$row);
                if($data[0] >= $data[1]) {
                    $result = 1;
                } else {
                    $result = 0;
                }

                $graphImage = Http::post(config('api.lab_url') . '/graph', $data)->body();
                $fileName = $sample['name'] . '-' . $rowKey . '-standard.png';
                Storage::disk('public')->put($fileName, $graphImage);

                $graphBvsImage = Http::post(config('api.lab_url') . '/graph-bvs', $data)->body();
                $fileBvsName = $sample['name'] . '-' . $rowKey . '-bvs.png';
                Storage::disk('public')->put($fileBvsName, $graphBvsImage);

                $sample = Sample::create([
                    'sample_id' => $sample['id'],
                    'data' => $row,
                    'result' => $result,
                    'graph_standard' => $fileName,
                    'graph_bvs' => $fileBvsName,
                    'rate_1' => $data[0],
                    'rate_2' => $data[1],
                    'rate_3' => $data[2],
                    'rate_4' => $data[3],
                    'rate_5' => $data[4],
                ]);

                if(Http::post(config('api.lab_url') . '/deep_analitics', $data)->ok()) {
                    $sample->deep_analitics = true;
                }
            }
        }

        return new JsonResponse(['success' => true]);
    }
}
