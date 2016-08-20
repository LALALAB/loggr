<?php

namespace Loggr\Formatter;

use \Loggr\Level;


class Message extends AbstractFormatter implements FormatterInterface{


    protected $_formats = [
        'default' => "{level} :: {time} - {message} \n"
    ];


    /**
     * @return $this
     */
    public function set_formats($formats){
        $this->_formats = $formats;
        return $this;
    }


    /**
     * @param $level
     * @param $format
     *
     * @return $this
     */
    public function set_format($level, $format){
        $this->_formats[$level] = $format;
        return $this;
    }


    /**
     * @param $level
     * @param $message
     * @param $context
     * @return mixed|null
     */
    public function format($level, $message, $context) {

        //First, interpolate the message with the context
        //Todo : merge the options to the context
        $message = $this->interpolate($message, $context);
        $format  = $this->_formats[$level] ? $this->_formats[$level] :  $this->_formats['default'];

        //Then, Interpolate the format string with the base variables and the options
        //Todo : merge the options to the base vars
        return $this->interpolate($format, [
            'level'   => \Loggr\Level::get_name($level),
            'time'    => $this->time()->format($this->_time_format, $this->_microtime),
            'message' => $message,
            'context' => ($context ? "\n" . $this->context()->format($context, $this->_context_format) : ""),
        ]);

    }



}