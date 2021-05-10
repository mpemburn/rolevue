<?php

namespace Mpemburn\RoleVue;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RoleVueServiceProvider extends ServiceProvider
{
    const NAMESPACE = 'Mpemburn\\RoleVue\\Controllers';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'rolevue');

        $this->publishes([
            // config file
            __DIR__.'/../config/rolevue.php' => config_path('rolevue.php'),
            // views
            __DIR__ . '/resources/views' => base_path('resources/views/vendor/rolevue')
        ], 'config');

        Route::middleware('api')
            ->prefix('api')
            ->namespace(self::NAMESPACE)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
            });

        Route::middleware('web')
            ->namespace(self::NAMESPACE)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
            });

        $this->loadViewsFrom(__DIR__.'/resources/views', 'rolevue');
    }
}
