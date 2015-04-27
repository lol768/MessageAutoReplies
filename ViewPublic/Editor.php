<?php

namespace MessageAutoReplies\ViewPublic;

use XenForo_ViewPublic_Base;

class Editor extends XenForo_ViewPublic_Base {

    public function renderHtml() {
        $this->_params['autoResponderEditor'] = \XenForo_ViewPublic_Helper_Editor::getEditorTemplate(
            $this, 'auto_responder', $this->_params['autoResponder']
        );
    }
} 