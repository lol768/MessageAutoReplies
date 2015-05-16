<?php

namespace MessageAutoReplies\Formatters;

/**
 * All formatters should be an instance of this class.
 * @package MessageAutoReplies\Formatters
 */
class AnonymousFormatter implements Formatter {
    /**
     * @var Callable
     */
    public $format;

    public function format($data) {
        return call_user_func_array($this->format, func_get_args());
    }
}
