<?php
namespace MessageAutoReplies\ControllerPublic;

use MessageAutoReplies\Util\ConversationUtil;
use XenForo_ControllerPublic_Abstract;
use XenForo_ControllerResponse_Redirect;
use XenForo_DataWriter;
use XenForo_DataWriter_ConversationMessage;
use XenForo_Helper_String;

/**
 * @see XenForo_ControllerPublic_Conversation
 * @package MessageAutoReplies\ControllerPublic
 */
class Conversation extends XFCP_Conversation {

    /**
     * @return XenForo_ControllerPublic_Abstract
     * @throws \Exception
     */
    public function actionInsert() {
        $response = parent::actionInsert();
        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $target = $response->redirectTarget;
            $targetId = ConversationUtil::getConversationIdFromUrl($target);
            $recipients = $this->getConversationModel()->getConversationRecipients($targetId);

            // TODO: For each recipient...
                // TODO: Use getAutoResponseModel() to see if the recipient has an auto response
                // TODO: Send the auto response if there is one. $recipients is an array of user id to user info array.
                // TODO: In PHP you can use foreach ($recipients as $userId => $userInfo)

            foreach ($recipients as $userId => $userInfo) {
                $autoReply = $this->getAutoResponseModel()->getEntryByUserId($userId); // TODO: this is most likely not correct as i don't quite get how this works *yet*
                if (!empty($autoReply)) {
                    $this->insertConversationMessage($targetId, $autoReply, $userId);
                }
            }
        }
        return $response;
    }

    /**
     * Sends a new reply to the given conversation.
     *
     * @param int $conversationId The conversation id.
     * @param string $message message to send.
     * @param $sendingUser
     * @throws \Exception
     * @throws \XenForo_Exception
     */
    private function insertConversationMessage($conversationId, $message, $sendingUser) {
        $message = XenForo_Helper_String::autoLinkBbCode($message);
        $messageDw = XenForo_DataWriter::create('XenForo_DataWriter_ConversationMessage');
        $messageDw->setExtraData(XenForo_DataWriter_ConversationMessage::DATA_MESSAGE_SENDER, $sendingUser);
        $messageDw->set('conversation_id', $conversationId);
        $messageDw->set('user_id', $sendingUser['user_id']);
        $messageDw->set('username', $sendingUser['username']);
        $messageDw->set('message', $message);
        $messageDw->save();
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
     * Grabs the XenForo conversation model.
     *
     * @return \XenForo_Model_Conversation
     */
    private function getConversationModel() {
        /** @var $this \XenForo_ControllerPublic_Abstract */
        return $this->getModelFromCache('XenForo_Model_Conversation');
    }

} 
