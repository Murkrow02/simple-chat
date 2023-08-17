<?php

namespace Murkrow\Chat\Http\Controllers;

use Illuminate\Routing\Controller;
use Murkrow\Chat\Events\NewMessageEvent;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;

class ChatController extends Controller
{
    //Post new message to specified chat
    public function newMessage()
    {
        //Get chat and check if user is in chat
        $loggedUser = auth()->user();

        /*  @var Chat $chat
            Find desired chat and check if user is in chat  */
        $chat = Chat::findOrFail(request('chat_id'));
        if (!$chat->users()->where('user_id', $loggedUser->id)->exists()) {
            abort(403);
        }

        /*  @var Message $newMessage
        Add message to chat  */
        $newMessage = $chat->addTextMessage($loggedUser->id, request('body'))->only(['id', 'body', 'user_id']);

        //Broadcast new message (in background to not stop request)
        broadcast(new NewMessageEvent($newMessage['body']));//->toOthers();

        return response()->json($newMessage);
    }


}