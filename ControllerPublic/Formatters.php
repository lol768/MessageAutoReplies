<?php

namespace MessageAutoReplies\ControllerPublic;

use XenForo_ControllerPublic_Abstract;

class Formatters extends XenForo_ControllerPublic_Abstract {

    public function actionShowHelp() {
        return $this->responseView('MessageAutoReplies\ViewPublic\Formatters', 'mar_formatters');
    }
} 