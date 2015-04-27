<?php

namespace MessageAutoReplies\ControllerPublic;

use XenForo_ControllerPublic_Abstract;
use XenForo_DataWriter;
use XenForo_Visitor;

class Editor extends XenForo_ControllerPublic_Abstract {

    public function actionEdit() {
        // Wrapping a view w/ the Account layout
        $viewData = array();

        $existingMessage = $this->getAutoResponseModel()->getEntryByUserId($this->getVisitorUserId());
        if (!$existingMessage) {
            $viewData['autoResponder'] = "";
        } else {
            $viewData['autoResponder'] = $existingMessage;
        }

        /** @var XenForo_ControllerHelper_Account $helper */
        $helper = $this->getHelper('Account');
        // Key goes below (see hook)
        return $helper->getWrapper("autoresponses", "edit", $this->responseView('MessageAutoReplies\ViewPublic\Editor', "mar_message_edit", $viewData));
    }

    public function actionSave() {
        $message = $this->getEditorHelper()->getMessageText('auto_responder', $this->_input);
        $this->handleAutoResponseChange($message, $this->getVisitorUserId());
        return $this->responseMessage("Your changes have been saved.");
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

    /**
     * @return \XenForo_ControllerHelper_Editor
     */
    protected function getEditorHelper() {
        return $this->getHelper('Editor');
    }
} 