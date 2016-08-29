<?php

namespace Loggr;


Class Log {


    static private $_envoys  = [];
    

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
        self::_notify_loggers($level, $message, $context);
    }


    /**
     * Add a Loggr class
     * @param LoggrInterface $Loggr
     * @param string $channel
     */
    static public function add_envoy(Envoy\EnvoyInterface $Envoy, $channel = 'default'){
        self::$_envoys[] = $Envoy;
    }


    /**
     * @param Loggr $Loggr
     */
    static public function add_loggr(Loggr $Loggr){

    }



    /**
     * Remove a Loggr Class
     * @param string $class
     * @return Log
     */
    static public function remove_logger($class){
        foreach(self::$_envoys as $index=> $o){
            if(is_a($o, $class)){
                unset(self::$_envoys[$index]);
            }
        }
    }


    /**
     * @param $level
     * @param $message
     * @param $context
     */
    static private function _notify_loggers($level, $message, $context = []){
        foreach(self::$_envoys as $Loggr){
            if(     $level >= $Loggr->get_min_level()
                 && $level <= $Loggr->get_max_level()) {
                
                $Loggr->log($level, $message, $context);
            }
        }
    }



}