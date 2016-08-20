<?php

namespace Loggr;


trait FormatableTrait{

    /**
     * @param $level
     * @param $message
     * @param $context
     * @return mixed|null
     */
    protected function _format_message($level, $message, $context) {

        $message = parent::_format_message($message, $context);

        if ($this->_formats[$level]) {
            $format = $this->_formats[$level];
            $log    = parent::_format_message($format, [
                'level'   => \Loggr\Level::get_name($level),
                'time'    => parent::_get_time(true),
                'message' => $message,
                'context' => ($context ? "\n" . parent::_format_context($context) : ""),
            ]);

            return $log;
        }
        return $message;
    }

}