<?php
namespace Murkrow\Chat\Utils;

class Utils{

    /**
     * Get the user class from config
     */
    static function getUserClass()
    {
        return config('simple-chat.user_class');
    }
}

