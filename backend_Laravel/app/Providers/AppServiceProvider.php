<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HMService;
use App\Services\LykdatService;
use App\Services\GithubAIService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HMService::class, function ($app) {
            return new HMService();
        });
        
        $this->app->singleton(LykdatService::class, function ($app) {
            return new LykdatService();
        });
        
        $this->app->singleton(GithubAIService::class, function ($app) {
            return new GithubAIService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
