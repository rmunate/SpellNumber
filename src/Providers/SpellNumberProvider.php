<?php

namespace Rmunate\Utilities\Providers;

use Illuminate\Support\ServiceProvider;

class SpellNumberProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/spell-number.php' => config_path('spell-number.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register any package-specific services here
    }
}
