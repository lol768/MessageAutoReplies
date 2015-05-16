<?php


namespace MessageAutoReplies\Listener\Dependencies;


use MessageAutoReplies\Formatters\AnonymousFormatter;
use MessageAutoReplies\Formatters\FormatterCollection;
use XenForo_Dependencies_Abstract;

/**
 * Listener for dependencies callback.
 * @package MessageAutoReplies\Listener\Dependencies
 */
class Initialize {

    public static function callback(XenForo_Dependencies_Abstract $dependencies, array $data) {
        $formatterCollection = new FormatterCollection();

        // Username formatter
        $usernameFormatter = new AnonymousFormatter();
        $usernameFormatter->format = function($data) {
            return $data['sender']['username'];
        };
        $formatterCollection->registerFormatter("username", $usernameFormatter);

        // User ID formatter
        $userIdFormatter = new AnonymousFormatter();
        $userIdFormatter->format = function($data) {
            return $data['sender']['user_id'];
        };
        $formatterCollection->registerFormatter("user_id", $userIdFormatter);

        // Register the dependency
        \XenForo_Application::set("mar_formatters", $formatterCollection);
    }
}
