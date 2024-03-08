<?php

namespace Murkrow\Chat\Http\Controllers;

use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
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
            ->select('chats.id', 'title', 'group')
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
                'id' => $chat->id,
                'chatName' => $chat->title,
                'secondLine' => $chat->group ? 'Group chat' : '',
                'isNewChat' => false,
                'timeStamp' => $chat->last_message_at,
                'imageUrl' => $chat->group ? asset('images/group-chat-icon.png') : asset('images/user-chat-icon.png')
            ])->render();

            // Add onclick event to open chat, replace first div tag
            $newChatCell = preg_replace('/<div/', '<div onclick="openChat(this)"', $newChatCell, 1);

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
        $newMessage = $chat->addTextMessage($loggedUser->id, request('body'));

        //Try to send message with pusher but don't crash if fail
        try {
           // NewMessageEvent::dispatch($newMessage);
        } catch (Exception $e) {

        }

        //Return newly created message
        return response()->json($newMessage->only(['id', 'body', 'user_id']));
    }

    /**
     * Start new chat with requested user and redirect to chat view
     * @param $targetUserId
     * @return Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function startNewChat($targetUserId): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        /* @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        //Start new chat with user
        $newChat = $loggedUser->startPrivateChat($targetUserId);
        if (!$newChat) {
            abort(404);
        }

        return redirect('chat/' . $newChat->id);
    }

    //Get a list of users to start a new chat from a specific category
    public function loadCategoryPage($categoryIndex, $page): JsonResponse
    {
        /* @var CanChat $loggedUser */
        $loggedUser = auth()->user();

        //Get user startable chat categories
        $result = $loggedUser->getStartableChatsCategories([]); //ADD FILTERS

        //Check if return value is string (only display error message)
        if (is_string($result)) {
            return response()->json(['error' => $result], 400);
        }

        /** At this point, $result is an array of StartableChatCategory
         * @var StartableChatCategory[] $categories
         */
        $categories = $result;

        //Get category by index
        $category = $categories[$categoryIndex];

        //Get page of users
        $users = $category->query->skip($page * 50)->take(50)->get(['id', 'name']);

        //Return users as blade component cells, already rendered and ready to be displayed
        $returnHtml = '';

        //Create a cell foreach user
        foreach ($users as $user) {

            $returnHtml .= view('chat::components.chat-cell', [
                'id' => $user->id,
                'chatName' => $user->name,
                'secondLine' => "",
                'isNewChat' => true,
                'timeStamp' => "",
                'imageUrl' => ""
            ])->render();
        }

        //Return final html string
        return response()->json($returnHtml, 200);
    }

}