<?php

namespace MessageAutoReplies\Formatters;

class AnonymousFormatter implements Formatter
{
    public $format;

    public function format($message, $data)
    {
        return call_user_func_array($this->format, func_get_args());
    }
}