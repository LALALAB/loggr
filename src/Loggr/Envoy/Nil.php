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
class Nil extends AbstractEnvoy implements EnvoyInterface{


    public function _write($level, $message, $context = null) {
        //Nil does nothing.
    }

}