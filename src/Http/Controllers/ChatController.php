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

        //Add message to chat
        $newMessage = $chat->addTextMessage($loggedUser->id, request('body'));

        try {
            NewMessageEvent::dispatch($newMessage);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }


        return response()->json($newMessage->only(['id', 'body', 'user_id']));
    }


}