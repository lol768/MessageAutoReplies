<?php

namespace MessageAutoReplies\ControllerPublic;

use XenForo_ControllerPublic_Abstract;

class Formatters extends XenForo_ControllerPublic_Abstract {

    public function actionShowHelp() {
        return $this->responseView(null, 'mar_formatters');
    }
} 
