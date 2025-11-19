<?php

namespace App\Providers;

use App\Models\CrmHeader;
use App\Observers\CrmHeaderObserver;
use Illuminate\Support\ServiceProvider;

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
        CrmHeader::observe(CrmHeaderObserver::class);
    }
}
