<?php

namespace Loggr;


Class Log {


    static private $_loggrs  = [];


    static private $_min_lvl       = Level::ALERT;


    /**
     * Define the maximum level for logging.
     * All logs under this level will be ignored
     *
     * @param $min_lvl
     */
    static public function set_min_level($min_lvl){
        self::$_min_lvl = $min_lvl;
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function debug($message, $context = []){
        self::write(Level::DEBUG, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function info($message, $context = []){
        self::write(Level::INFO, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function notice($message, $context = []){
        self::write(Level::NOTICE, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function warning($message, $context = []){
        self::write(Level::WARNING, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function error($message, $context = []){
        self::write(Level::ERROR, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function critical($message, $context = []){
        self::write(Level::CRITICAL, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function alert($message, $context = []){
        self::write(Level::ALERT, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function emergency($message, $context = []){
        self::write(Level::EMERGENCY, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function time($message, $context = []){
        self::write(Level::TIME, $message, $context);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function memory($message, $context = []){
        self::write(Level::MEMORY, $message, $context);
    }


    /**
     * @param int    $level
     * @param string $message
     * @param mixed  $context
     */
    static public function write($level, $message, $context = []){
        if($level >= self::$_min_lvl) {
            self::_notify_loggers($level, $message, $context);
        }
    }


    /**
     * Add a Logger class
     * @param LoggrInterface $Logger
     * @return Log
     */
    static public function add_logger(\Loggr\LoggrInterface $Loggr){
        self::$_loggrs[] = $Loggr;
    }


    /**
     * Remove a Logger Class
     * @param string $class
     * @return Log
     */
    static public function remove_logger($class){
        foreach(self::$_loggrs as $index=>$o){
            if(is_a($o, $class)){
                unset(self::$_loggrs[$index]);
            }
        }
    }


    /**
     * @param $level
     * @param $message
     * @param $context
     */
    static private function _notify_loggers($level, $message, $context){
        foreach(self::$_loggrs as $o){
            $o->log($level, $message, $context);
        }
    }



}