<?php

namespace MessageAutoReplies\Formatters;

class FormatterCollection {

    const FORMAT_PATTERN = '/((?<!\\\)\{(\w*)})/';
    const ESCAPED_PATTERN = '/\\\({.*})/';

    /** @var Formatter[] */
    public $formatters = array();
    private $data;

    public function registerFormatter($name, $formatter) {
        $this->formatters[$name] = $formatter;
    }

    public function format($message, $data) {
        $this->data = $data;

        $message = preg_replace_callback(self::FORMAT_PATTERN, [$this, "handleMatch"], $message);

        return preg_replace(self::ESCAPED_PATTERN, '$1', $message);
    }

    protected function handleMatch(array $matches) {
        $partialMatch = strtolower($matches[2]);

        if (array_key_exists($partialMatch, $this->formatters)) {
            $formatter = $this->formatters[$partialMatch];
            return $formatter->format($this->data);
        }
        return $matches[0];
    }
} 
