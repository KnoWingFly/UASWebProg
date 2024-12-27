<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('captcha', function($attribute, $value, $parameters)
        {
            return captcha_check($value);
        });
        if (!Storage::disk('public')->exists('events')) {
            Storage::disk('public')->makeDirectory('events');
        }
    }
}
