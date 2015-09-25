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
                'capitalize'  => Filters\Capitalize::class,
                'escape'      => Filters\EscapeHTML::class,
                'format_date' => Filters\FormatDate::class,
                'lowercase'   => Filters\Lowercase::class,
                'uppercase'   => Filters\Uppercase::class,
                'trim'        => Filters\Trim::class,
            ]);
        });
    }
}
