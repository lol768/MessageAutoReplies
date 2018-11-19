<?php
namespace MessageAutoReplies;
use XenForo_Application;

/**
 * Class MessageAutoReplies\Installer
 *
 * Handles addon installation and uninstallation.
 */
class Installer {

    /**
     * Install the addon.
     */
    public static function install() {
        /** @var \Zend_Db_Adapter_Abstract $db */
        $db = XenForo_Application::get('db');
        $db->query("CREATE TABLE IF NOT EXISTS xf_mar_messages (user_id INT UNSIGNED NOT NULL UNIQUE PRIMARY KEY, message_contents TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL)");
    }

    /**
     * Uninstalls the addon.
     */
    public static function uninstall() {
        /** @var \Zend_Db_Adapter_Abstract $db */
        $db = XenForo_Application::get('db');
        $db->query("DROP TABLE IF EXISTS xf_mar_messages");
    }
}
