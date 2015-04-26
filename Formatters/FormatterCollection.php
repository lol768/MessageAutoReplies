<?php

namespace MessageAutoReplies\Formatters;

class FormatterCollection {

    const FORMAT_PATTERN = "((\\{)(\\w*)(}))";

    public static $formatters;

    public static function format($message) {
        $offset = 0;
        while(preg_match($message, self::formatPattern, $matches, PREG_OFFSET_CAPTURE, $offset)){
            $offset = $matches[0][1] + strlen($matches[0][0]);
        }
    }
} 
