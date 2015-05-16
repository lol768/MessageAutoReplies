<?php


namespace MessageAutoReplies\Util;


use MessageAutoReplies\Exception\InvalidConversationUrlException;

class ConversationUtil {

    public static function getConversationIdFromUrl($url) {
        $regex = "/conversations\\/.*\\.([0-9]+)\\//";
        $matches = [];
        preg_match($regex, $url, $matches);
        if (count($matches) < 2) {
            throw new InvalidConversationUrlException("Too few matches!");
        }
        return $matches[1];
    }

}
