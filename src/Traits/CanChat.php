<?php

namespace Murkrow\Chat\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Models\StartableChatCategory;
use Murkrow\Chat\Utils\Utils;

/**
 * @method hasMany(string $class)
 * @method belongsToMany(string $class, string $string, string $string1, string $string2)
 * @property int $id
 */
trait CanChat
{
    public function chats() : BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'user_chats_pivot', 'user_id', 'chat_id');
    }


    /**
     * Start a private chat with another user
     * Create a new chat if one does not exist
     * @param $targetUserId
     * @return Chat|null
     */
    public function startPrivateChat($targetUserId): ?Chat
    {
        $loggedUserId = $this->id;

        //Check that user can actually chat with target user
        if($this->cannotChatWith($targetUserId))
            return null;

        //Check that user exists and is not the same as the current user
        $targetUser = config('simple-chat.user_class')::find($targetUserId);
        if(!$targetUser || $targetUserId == $loggedUserId)
            return null;

        //Check if chat already exists
        $chat = $this->chats()->whereHas('users', function($query) use ($targetUserId){
            $query->where('user_id', $targetUserId);
        })->first();

        //Return if chat exists
        if($chat)
            return $chat;

        //If chat does not exist, create it
        $chat = new Chat();
        $chat->group = false;
        $chat->save();

        //Add users to chat
        $this->chats()->save($chat);
        $targetUser->chats()->save($chat);

        Log::info('User {loggedUserId} started new private chat with {$targetUserId}',
            ['loggedUserId' => $loggedUserId, '$targetUserId'=>$targetUserId ]);

        //Return new chat
        return $chat;
    }

    /**
     * Groups chats by category based on the type of chat that can be started
     * This should be overridden in the user model to return the correct categories
     * @param $filters
     * @return array
     */
    public function getStartableChatsCategories($filters) : array
    {
        return [
            new StartableChatCategory('Users', Utils::getUserClass()::where('id', '!=', $this->id)->getQuery()),
        ];
    }

    /**
     * This method is invoked whenever a user intends to start a new chat with another one
     * Just return true or false to allow/deny the new chat creation
     */
    public function canChatWith($targetUser): bool
    {
        return true;
    }

    /**
     * Basically calls canChatWith and negates the result
     */
    public function cannotChatWith($targetUser): bool
    {
        return !$this->canChatWith($targetUser);
    }

}
