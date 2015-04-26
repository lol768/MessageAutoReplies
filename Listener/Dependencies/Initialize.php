<?php


namespace MessageAutoReplies\Listener\Dependencies;


use MessageAutoReplies\Formatters\AnonymousFormatter;
use MessageAutoReplies\Formatters\FormatterCollection;
use XenForo_Dependencies_Abstract;

class Initialize {

    public static function callback(XenForo_Dependencies_Abstract $dependencies, array $data) {
        $formatterCollection = new FormatterCollection();

        // Username formatter
        $usernameFormatter = new AnonymousFormatter();
        $usernameFormatter->format = function($data) {
            return $data['sender']['username'];
        };
        $formatterCollection->registerFormatter("username", $usernameFormatter);

        $fucksGivenFormatter = new AnonymousFormatter();
        $fucksGivenFormatter->format = function($data) {
            return 0;
        };
        $formatterCollection->registerFormatter("fucks_given", $fucksGivenFormatter);

        \XenForo_Application::set("mar_formatters", $formatterCollection);
    }
}
