<?php


namespace MessageAutoReplies\Util;


class ConversationUtil {

    public static function getConversationIdFromUrl($url) {
        $regex = "/conversations\\/.*\\.([0-9]+)\\//";
        $matches = [];
        preg_match($regex, $url, $matches);
        if (count($matches) < 2) {
            throw new \Exception("Too few matches!");
        }
        return $matches[1];
    }

}
