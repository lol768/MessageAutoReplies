<?php
namespace MessageAutoReplies\ControllerPublic;

use MessageAutoReplies\Util\ConversationUtil;
use XenForo_ControllerPublic_Abstract;
use XenForo_ControllerResponse_Redirect;
use XenForo_DataWriter;
use XenForo_DataWriter_ConversationMessage;
use XenForo_Helper_String;
use XenForo_Visitor;

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
            $useShortUrls = !\XenForo_Application::getOptions()->get("includeTitleInUrls");
            $targetId = ConversationUtil::getConversationIdFromUrl($target, $useShortUrls);
            $recipients = $this->getConversationModel()->getConversationRecipients($targetId);

            $data = [
                "sender" => XenForo_Visitor::getInstance()->toArray(),
            ];
            $collection = \XenForo_Application::get("mar_formatters");
            \XenForo_CodeEvent::fire('mar_setup_variable_formatters', array(&$collection));
            foreach ($recipients as $userId => $userInfo) {
                $autoReply = $this->getAutoResponseModel()->getEntryByUserId($userId);
                if (!empty($autoReply)) {
                    $formatted = $collection->format($autoReply, $data);
                    $this->insertConversationMessage($targetId, $formatted, $userInfo);
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
     * @param array $sendingUser The user info array.
     * @throws \Exception
     * @throws \XenForo_Exception
     */
    private function insertConversationMessage($conversationId, $message, array $sendingUser) {
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
