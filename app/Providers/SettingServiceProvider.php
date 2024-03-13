<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Retrieve settings from the database
        $settings =  app('db')
            ->table('settings')
            ->pluck('value', 'setting_name')
            ->toArray();

        // Bind the settings to the service container
        $this->app->singleton('settings', function () use ($settings) {
            return $settings;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
