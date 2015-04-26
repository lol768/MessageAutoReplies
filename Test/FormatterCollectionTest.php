<?php


namespace MessageAutoReplies\Test;


use MessageAutoReplies\Formatters\AnonymousFormatter;
use MessageAutoReplies\Formatters\FormatterCollection;
use PHPUnit_Framework_TestCase;

class FormatterCollectionTest extends PHPUnit_Framework_TestCase {

    public function testSimpleFormatter() {
        // TODO: CaptainBern!
        $fc = new FormatterCollection();
        // Make a simple formatter which changes {project} to "MCExchange"
        $projectFormatter = new AnonymousFormatter();
        $projectFormatter->format = function($data) {
            // !! Why do I need $message here? I'm replacing {project} only?
            return "MCExchange";
        };
        // TODO: I'd prefer a setFormatter($name, Formatter $implementation) method
        $fc->formatters["project"] = $projectFormatter;
        $this->assertSame("Hello from MCExchange", $fc->format("Hello from {project}"));
    }
}
