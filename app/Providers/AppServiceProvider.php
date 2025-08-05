<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //if you called service from auther provider service must you write it her
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //write her things that imolement and dose not dependence of other services
        Vite::prefetch(concurrency: 3);
    }
}
