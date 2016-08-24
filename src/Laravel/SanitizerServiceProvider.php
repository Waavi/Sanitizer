<?php

namespace Waavi\Sanitizer\Laravel;

use Illuminate\Support\ServiceProvider;

class SanitizerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register the sanitizer factory:
        $this->app->singleton('sanitizer', function ($app) {
            return new Factory;
        });

        // Register make request command
        $this->commands([
            RequestMakeCommand::class,
        ]);
    }
}
