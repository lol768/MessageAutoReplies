<?php
namespace MessageAutoReplies\Listener\Extend;


class ConversationController {
    public static function callback($class, array &$extend) {
        /** add our class to the list of those overriding @see \XenForo_ControllerPublic_Conversation */
        $extend[] = 'MessageAutoReplies\ControllerPublic\Conversation';
    }
} 
