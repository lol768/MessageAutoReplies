<?php

namespace MessageAutoReplies\Listener\Hook;

use XenForo_Template_Abstract;
use XenForo_Template_Public;

class VisitorTabLinks {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        $myTemplate = new XenForo_Template_Public("mar_navigation_visitor_tab_links2", $template->getParams());
        $contents .= $myTemplate->render();
    }
} 