<?php
namespace MessageAutoReplies\Listener\Extend;


class AccountViewPublic {
    public static function callback($class, array &$extend) {
        /** add our class to the list of those overriding @see XenForo_ViewPublic_Account_PersonalDetails */
        $extend[] = 'MessageAutoReplies\ViewPublic\Account\PersonalDetails';
    }
} 
