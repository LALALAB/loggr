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
        Level::$_max_level = $max_level;
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function debug($message, $context = null){
        Level::write(Level::DEBUG, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function info($message, $context = null){
        Level::write(Level::INFO, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function notice($message, $context = null){
        Level::write(Level::NOTICE, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function warning($message, $context = null){
        Level::write(Level::WARNING, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function error($message, $context = null){
        Level::write(Level::ERROR, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function critical($message, $context = null){
        Level::write(Level::CRITICAL, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function alert($message, $context = null){
        Level::write(Level::ALERT, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function emergency($message, $context = null){
        Level::write(Level::EMERGENCY, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function time($message, $context = null){
        Level::write(Level::TIME, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function memory($message, $context = null){
        Level::write(Level::MEMORY, $message, $context);
    }


    /**
     * @param int    $level
     * @param string $message
     * @param mixed  $context
     */
    static public function write($level, $message, $context = null){
        if($level <= Level::$_max_level) {
            Level::_notify_loggers($level, $message, $context);
        }
    }


    /**
     * Add a Logger class
     * @param LoggrInterface $Logger
     * @return Log
     */
    static public function add_logger($Logger){
        if(is_a($Logger, 'LoggrInterface')){
            Level::$_loggers[] = $Logger;
        }
    }


    /**
     * Remove a Logger Class
     * @param string $class
     * @return Log
     */
    static public function remove_logger($class){
        foreach(Level::$_loggers as $index=>$o){
            if(is_a($o, $class)){
                unset(Level::$_loggers[$index]);
            }
        }
    }


    /**
     * @param $level
     * @param $message
     * @param $context
     */
    static private function _notify_loggers($level, $message, $context){
        foreach(Level::$_loggers as $o){
            $o->log($level, $message, $context);
        }
    }



}