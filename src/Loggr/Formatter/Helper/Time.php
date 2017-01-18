<?php

namespace Loggr\Formatter\Helper;


class Time{


    /**
     * Format the current time
     */
    public function format($format = 'Y-m-d H:i:s', $micro = false){
        $time = date($format);

        if($micro){
            $time .= '.' . str_pad(array_pop(explode('.', microtime(true))), 6, 0, STR_PAD_LEFT);
        }

        return $time;
    }


}
