<?php


namespace MessageAutoReplies\Test;


use MessageAutoReplies\Util\ConversationUtil;
use PHPUnit_Framework_TestCase;

/**
 * Ensure that the regex used to grab the conversation id works.
 */
class ConversationUtilTest extends PHPUnit_Framework_TestCase {

    public function testConversationLinkExtractorWithRelativeUrl() {
        $url = "conversations/test.16/";
        $this->assertEquals(16, ConversationUtil::getConversationIdFromUrl($url));
    }

    public function testConversationLinkExtractorWithRelativeUrlAndLeadingSlash() {
        $url = "/conversations/test.16/";
        $this->assertEquals(16, ConversationUtil::getConversationIdFromUrl($url));
    }

    public function testConversationLinkExtractorWithAbsoluteUrl() {
        $url = "http://127.0.0.1/xf_latest/index.php?conversations/test.15/";
        $this->assertEquals(15, ConversationUtil::getConversationIdFromUrl($url));
    }

}
