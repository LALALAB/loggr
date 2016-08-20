<?php

namespace Loggr\Formatter ;



interface FormatterInterface{

    /**
     * @param $level
     * @param $message
     * @param $context
     * @return mixed|null
     */
    public function format($level, $message, $context);


}