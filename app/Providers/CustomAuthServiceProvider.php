<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('custom.auth', function () {
            return new \App\Services\CustomAuthService();
        });
    }
}