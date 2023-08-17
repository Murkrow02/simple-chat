<?php

namespace Murkrow\Chat\Http\Controllers;

use Illuminate\Routing\Controller;
use Murkrow\Chat\Models\Chat;

class ChatController extends Controller
{
    //Post new message to specified chat
    public function newMessage()
    {
        //Get chat and check if user is in chat
        $loggedUser = auth()->user();

        /* @var Chat $chat */
        $chat = Chat::findOrFail(request('chat_id'));
        if (!$chat->users()->where('user_id', $loggedUser->id)->exists()) {
            abort(403);
        }
        return response()->json([
            'message' => $chat->addTextMessage($loggedUser->id, request('body'))->only(['id', 'body', 'user_id'])
        ]);

    }


}