<?php

namespace Loggr;


Class Log {


    static private $_Loggr = null;


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