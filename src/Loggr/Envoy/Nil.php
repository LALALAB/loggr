<?php

namespace Loggr\Envoy;


/**
 * Class Nil
 *
 * This class is useless. It just does nothing.
 * Depend on your configuration, you can whether use a nil logger or configure max levels in static class.
 *
 * @package Loggr\Envoy
 */
class Nil extends \Loggr\AbstractLoggr implements \Loggr\LoggrInterface{


    public function log($level, $message, array $context = []) {
        //Nil does nothing.
    }

}