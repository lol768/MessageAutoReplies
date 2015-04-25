<?php
namespace MessageAutoReplies\ControllerPublic;

use XenForo_ControllerPublic_Account;
use XenForo_ControllerResponse_Redirect;
use XenForo_ControllerResponse_View;
use XenForo_DataWriter;
use XenForo_Input;
use XenForo_Visitor;

/**
 * @see XenForo_ControllerPublic_Account
 * @package MessageAutoReplies\ControllerPublic
 */
class Account extends XFCP_Account {

    /**
     * Override the save action of the parent controller.
     *
     * @see XenForo_ControllerPublic_Account::actionPersonalDetailsSave
     * @return \XenForo_ControllerResponse_Abstract
     * @throws \Exception
     * @throws \XenForo_Exception
     */
    public function actionPersonalDetailsSave() {
        $response = parent::actionPersonalDetailsSave();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $message = $this->getHelper('Editor')->getMessageText('auto_responder', $this->_input);
            $this->handleAutoResponseChange($message, $this->getVisitorUserId());
        }

        return $response;
    }

    /**
     * Handles the actual logic of updating/inserting the message content.
     *
     * @param string $message The message text (includes BBCode).
     * @param int $userId The user id for whom we will create the auto responder.
     * @throws \Exception
     */
    private function handleAutoResponseChange($message, $userId) {
        $dw = $this->getAutoResponseDataWriter();
        $previousEntry = $this->getAutoResponseModel()->getEntryByUserId($this->getVisitorUserId());
        if ($message == "") {
            // check to see if they already have an entry, if so remove it else skip
            if ($previousEntry !== false) {
                $dw->setExistingData(["user_id" => $userId]);
                $dw->delete();
            }
        } else {
            // user wants to set an auto response message
            // let's see if they already have one first and if so, update it
            // otherwise we'll make a new one
            $data = [
                "user_id" => $userId, "message_contents" => $message
            ];

            if (empty($previousEntry)) {
                $dw->bulkSet($data);
                $dw->save();
            } else {
                $dw->setExistingData($userId);
                $dw->bulkSet($data);
                $dw->save();
            }
        }
    }

    /**
     * Override the view function on the parent controller
     * to inject the default BBCode into the page's view
     * parameters.
     *
     * @see XenForo_ControllerPublic_Account::actionPersonalDetails
     * @return mixed
     */
    public function actionPersonalDetails() {
        $response = parent::actionPersonalDetails();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $existingMessage = $this->getAutoResponseModel()->getEntryByUserId($this->getVisitorUserId());
            if (!$existingMessage) {
                $response->subView->params['autoResponder'] = "";
            } else {
                $response->subView->params['autoResponder'] = $existingMessage;
            }
        }

        return $response;
    }

    /**
     * Retrieves the addon's model.
     *
     * @return \MessageAutoReplies\Model\AutoResponse
     */
    private function getAutoResponseModel() {
        /** @var $this \XenForo_ControllerPublic_Abstract */
        return $this->getModelFromCache('MessageAutoReplies\Model\AutoResponse');
    }

    /**
     * Grab the DataWriter for auto response entries.
     *
     * @return \MessageAutoReplies\DataWriter\AutoResponse
     * @throws \XenForo_Exception
     */
    private function getAutoResponseDataWriter() {
        return XenForo_DataWriter::create('MessageAutoReplies\DataWriter\AutoResponse');
    }

    /**
     * Grabs the current user's id.
     *
     * @return int
     */
    private function getVisitorUserId() {
        return XenForo_Visitor::getUserId();
    }
} 
