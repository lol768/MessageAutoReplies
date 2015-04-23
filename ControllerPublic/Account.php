<?php
namespace MessageAutoReplies\ControllerPublic;

use XenForo_ControllerPublic_Account;
use XenForo_ControllerResponse_Redirect;
use XenForo_ControllerResponse_View;
use XenForo_DataWriter;
use XenForo_Input;
use XenForo_Visitor;

class Account extends XFCP_Account {

    public function actionPersonalDetailsSave() {
        /** @var $this XenForo_ControllerPublic_Account */
        $response = parent::actionPersonalDetailsSave();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $message = $this->getInput()->filterSingle("auto_responder", XenForo_Input::STRING);

            $dw = XenForo_DataWriter::create('MessageAutoReplies\DataWriter\AutoResponse');

            $data = [
                "user_id" => XenForo_Visitor::getUserId(), "message_contents" => $message
            ];
            $dw->bulkSet($data);
            $dw->save();

            return $this->responseMessage($message);
        }

        return $response;
    }

    public function actionPersonalDetails() {
        $response = parent::actionPersonalDetails();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $response->subView->params['autoResponder'] = "abc";
        }

        return $response;
    }
} 