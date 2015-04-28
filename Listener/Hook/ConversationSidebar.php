<?php

namespace MessageAutoReplies\Listener\Hook;

use XenForo_Template_Abstract;
use XenForo_Template_Public;
use XenForo_Visitor;

class ConversationSidebar {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        if (!XenForo_Visitor::getInstance()->hasPermission("autoresponses", "autoresponses")) {
            return;
        }

        $myTemplate = new XenForo_Template_Public("mar_sidebar_link", $template->getParams());
        $contents .= $myTemplate->render();
    }
} 