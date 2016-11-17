<?php

namespace Loggr;

/**
 * Static convenient class for log.
 * Instanciate a single global Loggr and forward all static methods called to it.
 *
 * Class Log
 * @package Loggr
 */
Class Log {


    static private $_Loggr = null;


    /**
     * Forward all ::log, ::debug, ::add_envoy to a single instance og Loggr.
     * @param $name
     * @param $arguments
     */
    static public function __callStatic($name, $arguments){
        if(self::$_Loggr === null){
            self::_set_loggr_instance();
        }

        call_user_func_array([self::$_Loggr, $name], $arguments);
    }

    
    static private function _set_loggr_instance(){
        self::$_Loggr = new Loggr();
    }


}