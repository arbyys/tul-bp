<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Octane\Facades\Octane;
use App\Helpers\IntervalTaskHelper;

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
        Octane::tick('every10Seconds', fn() => IntervalTaskHelper::every10Seconds())->seconds(10)->immediate();
        Octane::tick('every1Hour', fn() => IntervalTaskHelper::every1Hour())->seconds(3600)->immediate();
    }
}
