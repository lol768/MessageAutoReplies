<?php

namespace MessageAutoReplies\Formatters;

class FormatterCollection {

    const FORMAT_PATTERN = '(?i)((?<!\\\)\{(\w*)})';

    /** @var Formatter[] */
    public $formatters = array();

    public function registerFormatter($name, $formatter) {
        $this->formatters[$name] = $formatter;
    }

    public function format($message, $data) {
        preg_match_all(self::FORMAT_PATTERN, $message, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[1] as $index => $fullMatch) {
            $partialMatch = $matches[2][$index];

            $formatter = $this->formatters[$partialMatch];

            if (empty($formatter)) {
                continue;
            }

            str_replace($fullMatch, $formatter->format($data), $message);
        }

        return $message;
    }
} 
