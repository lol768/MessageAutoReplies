<?php

namespace MessageAutoReplies\ViewPublic\Account;

class PersonalDetails extends XFCP_PersonalDetails {
    public function renderHtml() {
        $this->_params['autoResponderEditor'] = \XenForo_ViewPublic_Helper_Editor::getEditorTemplate(
            $this, 'auto_responder', $this->_params['autoResponder']
        );
    }
}
