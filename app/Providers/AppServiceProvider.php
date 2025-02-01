<?php

namespace App\Providers;
use App\View\Components\MenuItem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        // $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('menu-item', MenuItem::class);
    }
}
