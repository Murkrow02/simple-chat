<?php

namespace Murkrow\Chat\Http\Controllers;

use DB;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Murkrow\Chat\Events\NewMessageEvent;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\Message;
use Murkrow\Chat\Models\StartableChatCategory;
use Murkrow\Chat\Traits\CanChat;
use Murkrow\Chat\Utils\Utils;

class ChatController extends Controller
{


    /**
     * Displays the chat home view and loads the first chat cells
     * @return View
     */
    public function index(): View
    {
        return view('simple-chat::chat-home');
    }

    /**
     */
    public function getChats()
    {
        // Get pagination page
        $page = request('page') ?? 0;

        //Get all chats from logged user
        $chats = Utils::getLoggedUser()
            ->chats()
            ->select('chats.id', 'title', 'group', 'last_message_at')
            ->orderBy('last_message_at', 'desc')
            ->skip($page * config('simple-chat.chats_per_page'))
            ->limit(config('simple-chat.max_chats_download_limit'))
            ->get();

        // Create blade component for each chat
        $newChatCells = '';
        foreach ($chats as $chat) {

            //Set chat title if it is a private chat
            if (!$chat->group && $chat->title == null)
                $chat->title = $chat->users()->where('user_id', '!=', Utils::getLoggedUser()->id)->first()->name;

            // Create blade component
            $newChatCell = view('simple-chat::components.chat-cell', [
                'chatId' => $chat->id,
                'chatName' => $chat->title,
                'secondLine' => $chat->group ? 'Group chat' : '',
                'timeStamp' => $chat->last_message_at?->diffForHumans(),
                'imageUrl' => $chat->group ? asset('images/group-chat-icon.png') : asset('images/user-chat-icon.png')
            ])->render();

            // Add to final html string
            $newChatCells .= $newChatCell;
        }

        // Return new chat cells
        return response()->json($newChatCells);
    }

    public function getMessages($chatId)
    {
        // Get pagination page
        $page = request('page') ?? 0;

        // Get all messages from chat
        $loggedUser = Utils::getLoggedUser();
        $messages = $loggedUser
            ->chats()
            ->findOrFail($chatId)
            ->messages()
            ->get(['id', 'body', 'user_id'])->toArray();

        // Render chat bubbles
        $returnHtml = '';
        foreach ($messages as $message) {
            $returnHtml .= view('simple-chat::components.chat-bubble', [
                'message' => $message,
            ])->render();
        }

        // Return chat bubbles
        return response()->json($returnHtml);
    }

    // Get a list of users to start a new chat
    public function getNewChatUsers(): JsonResponse
    {
        // Get pagination page
        $page = request('page') ?? 0;

        // Get all users that can be chatted with
        $loggedUser = Utils::getLoggedUser();
        $users = $loggedUser->getUsersToStartChatWith()
            ->where('id', '!=', $loggedUser->id)
            ->skip($page * config('simple-chat.max_chats_download_limit'))
            ->limit(config('simple-chat.max_chats_download_limit'))
            ->get();


        // Create blade component for each user
        $newUserCells = '';
        /** @var CanChat $user */
        foreach ($users as $user) {

            // Create blade component
            $newUserCell = view('simple-chat::components.chat-cell', [
                'userId' => $user->id,
                'chatId' => '',
                'chatName' => $user->name,
                'secondLine' =>"Metti ruolo",
                'timeStamp' => '',
            ])->render();

            // Add to final html string
            $newUserCells .= $newUserCell;
        }

        // Return new user cells
        return response()->json($newUserCells);
    }


    //Post new message to specified chat
    public function newMessage(): JsonResponse
    {
        /*  @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        /*  @var Chat $chat
         * Find desired chat and check if user is in chat  */
        $chat = Chat::findOrFail(request('chat_id'));
        if (!$chat->users()->where('user_id', $loggedUser->id)->exists()) {
            abort(403);
        }

        //Add message to chat
        $newMessage = $chat
            ->addTextMessage($loggedUser->id, request('body'));

        //Try to send message with pusher but don't crash if fail
        try {
           // NewMessageEvent::dispatch($newMessage);
        } catch (Exception $e) {

        }

        //Return newly created message
        return response()->json(view('simple-chat::components.chat-bubble', [
            'message' => $newMessage,
        ])->render());
    }


    public function startNewChat(): JsonResponse
    {
        // Get user id from request
        $targetUserId = request('user_id');

        /* @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        //Check that user can actually chat with target user
        if($loggedUser->cannotChatWith($targetUserId))
            abort(403);

        //Check that user exists and is not the same as the current user
        $targetUser = config('simple-chat.user_class')::find($targetUserId);
        if(!$targetUser || $targetUserId == $loggedUser->id)
            abort(404);

        //Check if chat already exists
        /** @var Chat $chat */
        $chat = $loggedUser->chats()->whereHas('users', function($query) use ($targetUserId){
            $query->where('user_id', $targetUserId);
        })->first();

        //Return if chat exists
        if($chat)
            return response()->json($chat->id);

        //If chat does not exist, create it
        DB::beginTransaction();
        $chat = new Chat();
        $chat->group = false;
        $chat->save();

        //Add users to chat
        $loggedUser->chats()->save($chat);
        $targetUser->chats()->save($chat);
        DB::commit();

        //Return new chat id
        return response()->json($chat->id);
    }


}