<?php

declare(strict_types=1);

namespace Rmunate\Utilities\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Load the package configuration and make it publishable from Laravel.
 */
class SpellNumberProvider extends ServiceProvider
{
    /**
     * Register the defaults without overwriting application configuration.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/spell-number.php', 'spell-number');
    }

    /**
     * Register the configuration file for artisan vendor:publish.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/spell-number.php' => $this->app->configPath('spell-number.php'),
        ], 'config');
    }
}
