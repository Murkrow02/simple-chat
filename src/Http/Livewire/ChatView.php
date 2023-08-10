<?php

namespace Murkrow\Chat\Http\Livewire;

use Livewire\Component;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;

class ChatView extends Component
{
    public Chat $chat;              //The chat that is being viewed
    public $loggedUser;             //The logged user
    public array $messages = [];    //The chat messages
    public string $newMessage = ''; //The message that is being typed
    public string $chatTitle = '';   //The chat title displayed in the header

    public function mount($chatId)
    {
        //Get chat
        $this->chat = Chat::findOrFail($chatId);

        //Get all messages from chat
        $this->loggedUser = auth()->user();
        $this->messages = $this->loggedUser->chats()->findOrFail($chatId)->messages()->get()->toArray();

        //Get chat title
        $this->chatTitle = $this->chat->group ?

            //If chat is a group, return chat title
            $this->chat->title :

            //If chat is a private chat, return the other user name
            $this->chat->users()->where('user_id', '!=', $this->loggedUser->id)->first()->full_name;
    }


    /**
     * Sends a message to the chat
     * @return void
     */
    public function sendMessage(): void
    {
        //Return if message is empty
        if (empty($this->newMessage)) {
            return;
        }

        //Validate message
//        $this->validate([
//            'newMessage' => 'required|min:1|max:255',
//        ]);

        //Add message to chat
        $message = $this->chat->addTextMessage($this->loggedUser->id, $this->newMessage);

        //Add message to messages array
        $this->messages[] = $message->toArray();

        //Reset new message
        $this->newMessage = '';
        $this->emit('messageSent');
    }



    public function render()
    {
        return view('chat::livewire.chat-view')->layout('chat::layouts.app');
    }
}


