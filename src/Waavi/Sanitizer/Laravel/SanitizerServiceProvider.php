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
            return new Factory([
                'capitalize'  => \Waavi\Sanitizer\Filters\Capitalize::class,
                'escape'      => \Waavi\Sanitizer\Filters\EscapeHTML::class,
                'format_date' => \Waavi\Sanitizer\Filters\FormatDate::class,
                'lowercase'   => \Waavi\Sanitizer\Filters\Lowercase::class,
                'uppercase'   => \Waavi\Sanitizer\Filters\Uppercase::class,
                'trim'        => \Waavi\Sanitizer\Filters\Trim::class,
            ]);
        });
    }
}
