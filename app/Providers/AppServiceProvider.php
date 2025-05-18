<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FakeStoreService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FakeStoreService::class, function ($app) {
            return new FakeStoreService();
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
