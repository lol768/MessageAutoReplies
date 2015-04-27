<?php

namespace MessageAutoReplies\Listener\Hook;

use XenForo_Template_Abstract;
use XenForo_Template_Public;

class ConversationSidebar {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        $myTemplate = new XenForo_Template_Public("mar_sidebar_link", $template->getParams());
        $contents .= $myTemplate->render();
    }
} 