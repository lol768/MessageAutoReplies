<?php
namespace MessageAutoReplies\Listener\Extend;


class AccountController {
    public static function callback($class, array &$extend) {
        /** add our class to the list of those overriding @see XenForo_ControllerPublic_Account */
        $extend[] = 'MessageAutoReplies\ControllerPublic\Account';
    }
} 
