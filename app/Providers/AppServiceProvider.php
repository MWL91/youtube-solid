<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\EloquentSamplesRepository;
use App\Repositories\SamplesRepository;
use App\Services\DeepAnalyticsProcessor;
use App\Services\DeepAnalyticsService;
use App\Services\ExternalGraphGenerator;
use App\Services\GetResultService;
use App\Services\SampleFileProcessor;
use App\Services\SampleFileService;
use App\Services\SamplePipelineService;
use App\Services\SampleProcessor;
use App\Services\SampleProcessorService;
use App\Services\SampleResult;
use App\Services\SamplesGraph;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Feature::define('new-view', fn (?User $user) => true);

        $this->app->bind(SampleProcessor::class, SamplePipelineService::class);
        $this->app->bind(DeepAnalyticsProcessor::class, DeepAnalyticsService::class);
        $this->app->bind(SamplesRepository::class, EloquentSamplesRepository::class);
        $this->app->bind(SamplesGraph::class, ExternalGraphGenerator::class);
        $this->app->bind(SampleResult::class, GetResultService::class);
        $this->app->bind(SampleFileProcessor::class, SampleFileService::class);
    }
}
