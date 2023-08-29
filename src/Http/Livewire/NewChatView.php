<?php

namespace Murkrow\Chat\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;
use Murkrow\Chat\Models\StartableChatCategory;
use Murkrow\Chat\Traits\CanChat;

class NewChatView extends Component
{

    //How many chats to download at once
    private static int $downloadLimit = 50;

    //These categories can be immediately rendered as they have few items
    public $eagerCategories = [];

    //These categories will be loaded on demand
    public $lazyCategories = [];

    public function mount()
    {
        /*  @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        //Get query parameters and convert to array
        $queryParams = request()->query();

        //Get user startable chat categories
        $categories = $loggedUser->getStartableChatsCategories($queryParams);

        // Split chat categories with few items (which can be rendered immediately)
        // and the others (which will be loaded on demand)
        foreach ($categories as $category) {

            //if($category->query->count() < 10)
                $this->eagerCategories[$category->title] = $category->query ? $category->query->get() : [];
           // else
           //     $this->lazyCategories[$category->title] = $category->query;
        }
    }

    public function render()
    {
        return view('chat::livewire.new-chat-view')->layout('chat::layouts.app');
    }
}


