<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        \Illuminate\Support\Facades\Storage::extend('failover', function ($app, $config) {
            $manager = $app['filesystem'];
            $primary = $manager->disk($config['primary']);
            $fallback = $manager->disk($config['fallback']);

            return new \App\Extensions\FailoverFilesystem($primary, $fallback);
        });
    }
}
