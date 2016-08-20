<?php

namespace Loggr\Formatter\Helper;


class Context{

    /**
     * Format current context as php var export or Json
     */
     public function format($context, $format = 'json'){
        if($format == 'json'){
            return json_encode($context);
        }else{
            return var_export($context, true);
        }
    }
    
}