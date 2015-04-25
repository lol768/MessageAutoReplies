<?php

namespace MessageAutoReplies\Model;

use XenForo_Model;

class AutoResponse extends XenForo_Model {

    public function getEntryByUserId($userId) {
        return $this->_getDb()->fetchOne('SELECT message_contents FROM xf_mar_messages WHERE user_id = ?', $userId);
    }
    
    public function getEntireEntryByUserId($userId) {
        return $this->_getDb()->fetchRow('SELECT message_contents FROM xf_mar_messages WHERE user_id = ?', $userId);
    }
}
