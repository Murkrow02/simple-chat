<?php

namespace Murkrow\Chat\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;
use Murkrow\Chat\Traits\CanChat;

class NewChatView extends Component
{

    //How many chats to download at once
    private static int $downloadLimit = 50;

    //The startable chats
    public array $startableChats;

    public function mount()
    {
        /*  @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        //Get user startable chat categories
        $categories = $loggedUser->getStartableChatsCategories(['condominium_id' => 1]);

        /* For now use only first category */
        $this->startableChats = $categories[0]->query->get()->toArray();
    }

    public function render()
    {
        return view('chat::livewire.new-chat-view')->layout('chat::layouts.app');
    }
}


