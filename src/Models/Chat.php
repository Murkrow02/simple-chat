<?php

namespace Murkrow\Chat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property bool $group
 * @method static findOrFail($chatId)
 */
class Chat extends Model
{
    protected $fillable = [
        'title',
        'group',
    ];

    protected $casts = [
        'group' => 'boolean',
    ];


    /**
     * Appends a new message to the chat
     * @param int $userId
     * @param string $message
     * @return Message
     */
    public function addTextMessage(int $userId, string $message): Message
    {
        //Create new message
        $newMessage = new Message();
        $newMessage->user_id = $userId;
        $newMessage->body = $message;
        $newMessage->chat_id = $this->id;
        $newMessage->save();
        return $newMessage;
    }

    /* RELATIONSHIPS */

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }



    public function users(): BelongsToMany
    {
        //Return from pivot user chats
        return $this->belongsToMany(config('simple-chat.user_class'), 'user_chats_pivot', 'chat_id', 'user_id');
    }
}