<?php

namespace Murkrow\Chat;


use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Murkrow\Chat\Http\Livewire\ChatCell;
use Murkrow\Chat\Http\Livewire\SingleChat;
use Murkrow\Chat\Http\Livewire\ChatHome;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chat');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'simple-chat');

    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/simple-chat.php' => config_path('simple-chat.php'),], 'config');
        $this->publishes([
            __DIR__.'/../resources/js' => public_path('simple-chat/js'), ], 'public');
        $this->publishes([
            __DIR__.'/../resources/css' => public_path('simple-chat/css'), ], 'public');
        $this->publishes([
            __DIR__.'/../lang' => lang_path(''), ], 'lang');

        // Register Livewire components
        Livewire::component('single-chat', SingleChat::class);
        Livewire::component('murkrow.chat.http.livewire.chat-home', ChatHome::class);
    }
}
