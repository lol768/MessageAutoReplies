<?php

namespace MessageAutoReplies\Listener\Dependencies;

use MessageAutoReplies\Formatters\AnonymousFormatter;
use MessageAutoReplies\Formatters\FormatterCollection;
use XenForo_Dependencies_Abstract;

class Init {

    public static function callback(XenForo_Dependencies_Abstract $dependencies, array $data) {
        $formatterCollections = new FormatterCollection();
        $formatterCollections::$formatters = array();

        // Username formatter
        $usernameFormatter = new AnonymousFormatter();
        $usernameFormatter->format = function($message) {
            return null;
        };
        $formatterCollections::$formatters[] = ["username" => $usernameFormatter];

        $fucksGivenFormatter = new AnonymousFormatter();
        $fucksGivenFormatter->format = function($message) {
            return 0;
        };
    }
}