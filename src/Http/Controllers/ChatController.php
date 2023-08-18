<?php

namespace Murkrow\Chat\Http\Controllers;

use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Murkrow\Chat\Events\NewMessageEvent;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;
use Murkrow\Chat\Models\StartableChatCategory;
use Murkrow\Chat\Traits\CanChat;

class ChatController extends Controller
{
    //Post new message to specified chat
    public function newMessage(): JsonResponse
    {
        /*  @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        /*  @var Chat $chat
            Find desired chat and check if user is in chat  */
        $chat = Chat::findOrFail(request('chat_id'));
        if (!$chat->users()->where('user_id', $loggedUser->id)->exists()) {
            abort(403);
        }

        //Add message to chat
        $newMessage = $chat->addTextMessage($loggedUser->id, request('body'));

        //Try to send message with pusher but don't crash if fail
        try {
            NewMessageEvent::dispatch($newMessage);
        } catch (Exception $e) {

        }

        //Return newly created message
        return response()->json($newMessage->only(['id', 'body', 'user_id']));
    }

    //Start new chat with requested user and redirect to chat view
    public function startNewChat($targetUserId): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        /* @var CanChat $loggedUser */
        $loggedUser = auth()->user();
        if(!$loggedUser->canChatWith($targetUserId))
            abort(403);

        //Start new chat with user
        $newChat = $loggedUser->startPrivateChat($targetUserId);

        return redirect('chats/'.$newChat->id);
    }
}