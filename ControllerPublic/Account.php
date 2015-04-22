<?php
namespace MessageAutoReplies\ControllerPublic;

use XenForo_ControllerPublic_Account;
use XenForo_ControllerResponse_Redirect;
use XenForo_Input;

class Account extends XFCP_Account {

    public function actionPersonalDetailsSave() {
        /** @var $this XenForo_ControllerPublic_Account */
        $response = parent::actionPersonalDetailsSave();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $message = $this->getInput()->filterSingle("auto_responder", XenForo_Input::STRING);
            return $this->responseMessage($message);
        }

        return $response;
    }
} 