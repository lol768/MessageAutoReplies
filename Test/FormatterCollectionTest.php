<?php

namespace MessageAutoReplies\Test;

use MessageAutoReplies\Formatters\AnonymousFormatter;
use MessageAutoReplies\Formatters\FormatterCollection;
use PHPUnit_Framework_TestCase;

class FormatterCollectionTest extends PHPUnit_Framework_TestCase {

    public function testSimpleFormatter() {
        $fc = new FormatterCollection();

        // Make a simple formatter which changes {project} to "MCExchange"
        $projectFormatter = new AnonymousFormatter();
        $projectFormatter->format = function($data) {
            return "MCExchange";
        };

        $fc->registerFormatter("project", $projectFormatter);

        $data = array();
        $this->assertSame("Hello from MCExchange", $fc->format("Hello from {project}", $data));
    }

    public function testFormatterWithData() {
        $fc = new FormatterCollection();

        $dataFormatter = new AnonymousFormatter();
        $dataFormatter->format = function($data) {
            return $data['custom_data'];
        };

        $fc->registerFormatter("custom_data", $dataFormatter);

        $data = ['custom_data' => "Some custom data!"];
        $this->assertSame("Custom data: Some custom data!", $fc->format("Custom data: {custom_data}", $data));
    }

    public function testEscapedFormatter() {
        $fc = new FormatterCollection();

        $projectFormatter = new AnonymousFormatter();
        $projectFormatter->format = function($data) {
            return "MCExchange";
        };

        $fc->registerFormatter("project", $projectFormatter);

        $data = array();
        $this->assertSame("Hello from {project} {unknown} MCExchange", $fc->format("Hello from \\{project} {unknown} {project}", $data));
    }
}
