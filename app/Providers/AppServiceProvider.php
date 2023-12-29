<?php

namespace App\Providers;

use App\Models\User;
use App\Services\ProcessSampleService;
use App\Services\SampleProcessor;
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

        $this->app->bind(
            SampleProcessor::class,
            ProcessSampleService::class
        );
    }
}
