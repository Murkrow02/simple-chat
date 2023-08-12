<?php

namespace Murkrow\Chat\Http\Livewire;

use Livewire\Component;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;

class ChatsView extends Component
{


    public function mount()
    {

    }


    public function render()
    {
        return view('chat::livewire.chats-view')->layout('chat::layouts.app');
    }
}


