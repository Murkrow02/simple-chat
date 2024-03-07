<?php
namespace Murkrow\Chat\Utils;

use Murkrow\Chat\Traits\CanChat;

class Utils{

    /**
     * Get the user class from config
     */
    static function getUserClass()
    {
        return config('simple-chat.user_class');
    }

    /**
     * Get the logged user
     * @return CanChat
     */
    static function getLoggedUser()
    {
        return auth()->user();
    }
}

