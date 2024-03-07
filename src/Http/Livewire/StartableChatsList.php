<?php

namespace Murkrow\Chat\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\StartableChatCategory;
use Murkrow\Chat\Traits\CanChat;

class StartableChatsList extends Component
{

    //How many chats to download at once
    private static int $downloadLimit = 50;

    //These categories can be immediately rendered as they have few items
    public $listedCategories = []; // This array will be filled with the startable chats

    //These categories will be loaded on demand
    public $collapsedCategories = []; // This array will be filled with the id of the lazy category to be loaded

    //Error message to display
    public ?string $errorMessage;

    public function mount()
    {
        /*  @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        //Get query parameters and convert to array
        $queryParams = request()->query();

        //Get user startable chat categories
        $result = $loggedUser->getStartableChatsCategories($queryParams);

        //Check if return value is string (only display error message)
        if(is_string($result))
        {
            $this->errorMessage = $result;
            return;
        }

        /** At this point, $result is an array of StartableChatCategory
         *  @var StartableChatCategory[] $categories
         */
        $categories = $result;

        // Split chat categories with few items (which can be rendered immediately)
        // and the others (which will be loaded on demand)
        foreach ($categories as $index => $category) {

            //A lot of items or forced to collapse
            if ($category->query->count() > 10 || $category->forceCollapse)
                $this->collapsedCategories[$category->title] = $index;

            //Few items
            else
                $this->listedCategories[$category->title] = $category->query ? $category->query->get(['id','name']) : [];
        }
    }

    public function render()
    {
        return view('chat::livewire.startable-chats-list')->layout('chat::layouts.app');
    }
}


