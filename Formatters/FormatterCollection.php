<?php

namespace MessageAutoReplies\Formatters;

class FormatterCollection {

    const FORMAT_PATTERN = "((\\{)(\\w*)(}))";

    public $formatters;

    public static function format($message) {
        $offset = 0;
        while(preg_match($message, self::FORMAT_PATTERN, $matches, PREG_OFFSET_CAPTURE, $offset)){
            $offset = $matches[0][1] + strlen($matches[0][0]);
        }
    }
} 