<?php

namespace Murkrow\Chat\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;
use Murkrow\Chat\Traits\CanChat;
use Murkrow\Chat\Utils\Utils;

class ChatHome extends Component
{

    //How many chats to download at once
    private static int $downloadLimit = 50;

    //The downloaded chats
    public array $chats = [];

    public function mount()
    {
        //Get all chats from logged user (only 50)
        $chats = Utils::getLoggedUser()
            ->chats()
            ->select('chats.id', 'title', 'group')
            ->limit(self::$downloadLimit)
            ->get();

        //Fill non-group chats with the other username
        foreach ($chats as $chat) {

            //Set chat title if it is a private chat
            if(!$chat->group && $chat->title == null)
                $chat->title = $chat->users()->where('user_id', '!=', Utils::getLoggedUser()->id)->first()->name;


            $this->chats[] = $chat;
        }
    }



    public function render()
    {
        return view('chat::livewire.chat-home')->layout('chat::layouts.app');
    }
}


