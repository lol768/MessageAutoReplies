<?php


namespace MessageAutoReplies\Test;


use MessageAutoReplies\Formatters\FormatterCollection;
use PHPUnit_Framework_TestCase;

class FormatterCollectionTest extends PHPUnit_Framework_TestCase {

    public function testSimpleFormatter() {
        // TODO: CaptainBern!

        FormatterCollection::format("This is some {test} with given {patterns} . Let's hope it {works}!");
    }
}
