<?php

namespace MessageAutoReplies\Formatters;

interface Formatter {

    /** Data is an array:
     *
     * $data = [
     *     "sender" => $senderUserInfo
     * ]
     *
     * @param $data
     * @return mixed
     */
    public function format($data);
}




