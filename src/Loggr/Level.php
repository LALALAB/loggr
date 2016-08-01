<?php

namespace Loggr;

Class Level {

    const EMERGENCY = 80;
    const ALERT     = 70;
    const CRITICAL  = 60;
    const ERROR     = 50;
    const WARNING   = 40;
    const NOTICE    = 30;
    const INFO      = 20;
    const DEBUG     = 10;
    const TIME      = 5;
    const MEMORY    = 5;


    static public function get_name($lvl){
        switch($lvl){
            case self::MEMORY    : return 'MEMORY';
            case self::TIME      : return 'TIME';
            case self::DEBUG     : return 'DEBUG';
            case self::INFO      : return 'INFO';
            case self::NOTICE    : return 'NOTICE';
            case self::WARNING   : return 'WARNING';
            case self::ERROR     : return 'ERROR';
            case self::CRITICAL  : return 'CRITICAL';
            case self::ALERT     : return 'ALERT';
            case self::EMERGENCY : return 'EMERGENCY';
        }

        return '';
    }



}