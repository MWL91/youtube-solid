<?php

use App\Http\Controllers\DeepAnalitycsController;
use App\Http\Controllers\GraphBvsController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\ProcessSamplesController;
use App\Http\Controllers\SamplesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('samples', SamplesController::class);
Route::post('process', ProcessSamplesController::class);
Route::post('graph', GraphController::class);
Route::post('graph-bvs', GraphBvsController::class);
Route::post('deep_analitics', DeepAnalitycsController::class);
