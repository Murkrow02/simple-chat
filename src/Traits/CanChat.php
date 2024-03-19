<?php

namespace Murkrow\Chat\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Murkrow\Chat\Models\Chat;
use Murkrow\Chat\Utils\Utils;

/**
 * @method hasMany(string $class)
 * @method belongsToMany(string $class, string $string, string $string1, string $string2)
 * @property int $id
 */
trait CanChat
{

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function chats() : BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'user_chats_pivot', 'user_id', 'chat_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */
    public function getAvatarUrlAttribute(): string
    {
        return '/simple-chat/img/avatar.svg';
    }

    public function getSecondLineAttribute(): string
    {
        return '';
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
    public function getUsersToStartChatWith() : Builder
    {
        return Utils::getUserClass()::where('id', '!=', $this->id);
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
