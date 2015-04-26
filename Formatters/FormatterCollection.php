<?php

namespace MessageAutoReplies\Formatters;

class FormatterCollection {

    const FORMAT_PATTERN = '(?i)((?<!\\\)\{(\w*)})';

    /** @var Formatter[] */
    public $formatters;

    public function format($message) {
        preg_match_all(self::FORMAT_PATTERN, $message, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[1] as $match) {
            $formatter = $this->formatters[$match];

            if (empty($formatter))
                continue;

            // TODO: Remove these curly braces
            str_replace("{" . $match . "}", $formatter->format(null), $message);

            echo $match;
        }
    }
} 
