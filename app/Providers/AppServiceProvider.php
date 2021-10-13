<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
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
        if ($this->app->environment('production')) {
            $this->app->bind('path.public', function () {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('filter', function ($attribute, $value) {
            $black = ['god', 'allah', 'sex'];
            foreach ($black as $word) {
                if (stripos($value, $word) !== false) {
                    return false;
                }
            }
            return true;
        }, 'This word is not allowed');

        Paginator::useBootstrap();
    }
}
