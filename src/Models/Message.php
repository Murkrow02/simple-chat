<?php

namespace Murkrow\Chat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $body
 * @property int $chat_id
 * @property int $user_id
 */
class Message extends Model
{
    protected $table = 'chat_messages';
    protected $fillable = [
        'body',
        'chat_id',
        'user_id',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

}