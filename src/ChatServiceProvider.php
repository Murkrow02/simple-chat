<?php

namespace Murkrow\Chat;


use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function boot()
    {
    }
}
