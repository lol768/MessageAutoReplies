<?php

namespace MessageAutoReplies\DataWriter;

use XenForo_DataWriter;

class AutoResponse extends XenForo_DataWriter {

    protected function _getFields() {
        return array(
            'xf_mar_messages' => array(
                'user_id' => array(
                    'type' => self::TYPE_UINT,
                ),
                'message_contents' => array(
                    'type' => self::TYPE_STRING,
                ),
            )
        );
    }

    protected function _getExistingData($data) {
        // Check by existing primary key ('user_id')
        if (!$id = $this->_getExistingPrimaryKey($data, 'user_id')) {
            return false;
        }
        return array('xf_mar_messages' => $this->getAutoResponseModel()->getEntryById($id));
    }

    protected function _getUpdateCondition($tableName) {
        // primary
        return 'user_id = ' . $this->_db->quote($this->getExisting('user_id'));
    }

    /**
     * @return \MessageAutoReplies\Model\AutoResponse
     */
    private function getAutoResponseModel() {
        return $this->getModelFromCache('MessageAutoReplies\Model\AutoResponse');
    }

}