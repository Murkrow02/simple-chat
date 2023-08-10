<?php

namespace Murkrow\Chat;


use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Murkrow\Chat\Http\Livewire\ChatView;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chat');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');


        Livewire::component('murkrow.chat.http.livewire.chat-view', ChatView::class);

    }

    public function boot()
    {
    }
}
