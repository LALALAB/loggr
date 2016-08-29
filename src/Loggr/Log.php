<?php

namespace Loggr;


Class Log {


    static private $_envoys    = [];


    static private $_channels  = [];





    static public function __callStatic($name, $arguments){

        if(isset(self::$_channels[$name])){
            return self::$_channels[$name];
        }else if (isset(self::$_channels['default'])) {
            return self::$_channels['default'];
        }else{
            //error
        }

    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function debug($message, $context = [], $channels = []){
        self::write(Level::DEBUG, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function info($message, $context = [], $channels = []){
        self::write(Level::INFO, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function notice($message, $context = [], $channels = []){
        self::write(Level::NOTICE, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function warning($message, $context = [], $channels = []){
        self::write(Level::WARNING, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function error($message, $context = [], $channels = []){
        self::write(Level::ERROR, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function critical($message, $context = [], $channels = []){
        self::write(Level::CRITICAL, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function alert($message, $context = [], $channels = []){
        self::write(Level::ALERT, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function emergency($message, $context = [], $channels = []){
        self::write(Level::EMERGENCY, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function time($message, $context = [], $channels = []){
        self::write(Level::TIME, $message, $context, $channels);
    }


    /**
     * @param string $message
     * @param array $context
     */
    static public function memory($message, $context = [], $channels = []){
        self::write(Level::MEMORY, $message, $context, $channels);
    }


    /**
     * @param int    $level
     * @param string $message
     * @param mixed  $context
     */
    static public function write($level, $message, $context = [], $channels = []){
        self::_notify($level, $message, $context, $channels);
    }


    /**
     * Add a Loggr class
     * @param LoggrInterface $Loggr
     * @param string $channel
     */
    static public function add_envoy(Envoy\EnvoyInterface $Envoy, $channel = 'default'){
        if( !isset(self::$_channels[$channel]) ){
            self::$_channels[$channel] = new Channel($channel);
        }

        self::$_channels[$channel]->add($Envoy);
    }


    /**
     * @param Loggr $Loggr
     */
    static public function add_channel(Channel $Channel){
        self::$_channels[$Channel->get_name()] = $Channel;
    }



    /**
     * @param $level
     * @param $message
     * @param $context
     */
    static private function _notify($level, $message, $context = [], $channels){
        if(empty($channels)){
            $channels = self::_get_implicit_channels();
        }

        foreach($channels as $name){
            if(isset(self::$_channels[$name])){

                self::$_channels[$name]->log($level, $message, $context);
            }
        }
    }


    static private function _get_implicit_channels(){

        $channels = [];

        foreach(self::$_channels as $Channel){
            if(!$Channel->is_explicit()){
                $channels[] = $Channel->get_name();
            }
        }
        return $channels;
    }



}