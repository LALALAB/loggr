<?php

namespace Loggr;


Class Log {


    static private $_loggers  = [];


    static private $_max_level       = Level::ALERT;


    /**
     * Define the maximum level for logging.
     * All logs under this level will be ignored
     *
     * @param $max_level
     */
    static public function set_max_level($max_level){
        self::$_max_level = $max_level;
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function debug($message, $context = null){
        self::write(self::DEBUG, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function info($message, $context = null){
        self::write(self::INFO, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function notice($message, $context = null){
        self::write(self::NOTICE, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function warning($message, $context = null){
        self::write(self::WARNING, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function error($message, $context = null){
        self::write(self::ERROR, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function critical($message, $context = null){
        self::write(self::CRITICAL, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function alert($message, $context = null){
        self::write(self::ALERT, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function emergency($message, $context = null){
        self::write(self::EMERGENCY, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function time($message, $context = null){
        self::write(self::TIME, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function memory($message, $context = null){
        self::write(self::MEMORY, $message, $context);
    }


    /**
     * @param int    $level
     * @param string $message
     * @param mixed  $context
     */
    static public function write($level, $message, $context = null){
        if($level <= self::$_max_level) {
            self::_notify_loggers($level, $message, $context);
        }
    }


    /**
     * Add a Logger class
     * @param LoggrInterface $Logger
     * @return Log
     */
    static public function add_logger($Logger){
        if(is_a($Logger, 'LoggrInterface')){
            self::$_loggers[] = $Logger;
        }
    }


    /**
     * Remove a Logger Class
     * @param string $class
     * @return Log
     */
    static public function remove_logger($class){
        foreach(self::$_loggers as $index=>$o){
            if(is_a($o, $class)){
                unset(self::$_loggers[$index]);
            }
        }
    }


    /**
     * @param $level
     * @param $message
     * @param $context
     */
    static private function _notify_loggers($level, $message, $context){
        foreach(self::$_loggers as $o){
            $o->log($level, $message, $context);
        }
    }



}