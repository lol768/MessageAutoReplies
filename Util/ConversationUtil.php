<?php


namespace MessageAutoReplies\Util;


use MessageAutoReplies\Exception\InvalidConversationUrlException;

class ConversationUtil {

    public static function getConversationIdFromUrl($url, $shortIds=false) {
        $regex = "/conversations\\/.*\\.([0-9]+)\\//";
        if ($shortIds) {
            $regex = "/conversations\\/([0-9]+)\\//";
        }
        $matches = [];
        preg_match($regex, $url, $matches);
        if (count($matches) < 2) {
            throw new InvalidConversationUrlException("Too few matches! The original string passed in was '" . $url . "'");
        }
        return $matches[1];
    }

}
