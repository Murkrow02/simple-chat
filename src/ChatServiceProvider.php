<?php

namespace Murkrow\Chat;


use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Murkrow\Chat\Http\Livewire\ChatView;
use Murkrow\Chat\View\Components\ChatCell;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chat');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/simple-chat.php', 'simple-chat');

        //
        $this->loadViewComponentsAs('chat', [
            ChatCell::class,
        ]);

        Livewire::component('murkrow.chat.http.livewire.chat-view', ChatView::class);
        Livewire::component('murkrow.chat.http.components.chat-cell', ChatCell::class);


    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/simple-chat.php' => config_path('simple-chat.php'),
        ], 'config');
    }
}
