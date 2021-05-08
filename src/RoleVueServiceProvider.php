<?php

namespace Mpemburn\RoleVue;

use Illuminate\Support\ServiceProvider;

class RoleVueServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'rolevue');

        $this->publishes([
            __DIR__.'/../config/rolevue.php' => config_path('rolevue.php'),
            __DIR__ . '/resources/views' => base_path('resources/views/vendor/rolevue')
        ], 'config');

        $this->app['router']->namespace('Mpemburn\\RoleVue\\Controllers')
            ->middleware(['api'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
            });

        $this->loadViewsFrom(__DIR__.'/resources/views', 'rolevue');
    }
}
