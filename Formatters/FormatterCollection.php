<?php

namespace MessageAutoReplies\Formatters;

class FormatterCollection {

    const FORMAT_PATTERN = "(?i)((?<!\\)\{(\w*)})";

    public $formatters;

    public function format($message) {
        preg_match_all(self::FORMAT_PATTERN, $message, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[1] as $match) {
            $formatter = $this->formatters[$match];

            if (empty($formatter))
                continue;

            str_replace("{" . $match . "}", $formatter->format($message, null), $message);

            echo $match;
        }
    }
} 
