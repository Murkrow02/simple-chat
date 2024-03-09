<?php

namespace Murkrow\Chat\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
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

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function getUsersToStartChatWith() : Builder
    {
        return Utils::getUserClass()::getQuery();
    }

    /**
     * This method is invoked whenever a user intends to start a new chat with another one
     * Just return true or false to allow/deny the new chat creation
     */
    public function canChatWith($targetUserId): bool
    {
        return true;
    }

    /**
     * Basically calls canChatWith and negates the result
     */
    public function cannotChatWith($targetUserId): bool
    {
        return !$this->canChatWith($targetUserId);
    }

}
