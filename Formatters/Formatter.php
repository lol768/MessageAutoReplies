<?php

namespace MessageAutoReplies\Formatters;

interface Formatter {

    /** Data is an array:
     *
     * $data = [
     *     "recipient" => $recipientUserInfo
     * ]
     *
     * @param $data
     * @return mixed
     */
    public function format($data);
}




