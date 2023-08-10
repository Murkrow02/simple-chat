<?php

namespace Murkrow\Chat\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Murkrow\Chat\Models\Chat;

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
        //Check that user exists and is not the same as the current user
        $targetUser = $this->find($targetUserId);
        if(!$targetUser || $targetUserId == $this->id){
            return null;
        }

        //Check if chat already exists
        $chat = $this->chats()->where('group', false)->whereHas('users', function($query) use ($targetUserId){
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

        //Return new chat
        return $chat;
    }
}
