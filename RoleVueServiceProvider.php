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
    }

}
