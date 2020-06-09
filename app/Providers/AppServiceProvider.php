<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('active', function ($path) {
            $current_path = basename(request()->path());

            if (is_array($path)) {
                return in_array($current_path, $path, true);
            }

            return $path === $current_path;
        });
    }
}
