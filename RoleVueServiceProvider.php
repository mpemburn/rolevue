<?php

namespace Mpemburn\RoleVue;

use Illuminate\Support\ServiceProvider;

class RoleVueServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/rolevue.php' => config_path('rolevue.php'),
        ], 'config');

        $this->app['router']->namespace('Mpemburn\\RoleVue\\Controllers')
            ->middleware(['api'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });

    }

}
