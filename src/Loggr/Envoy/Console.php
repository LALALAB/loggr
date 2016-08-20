<?php

namespace Loggr\Envoy;


/**
 * Class Console
 *
 * @package Loggr\Envoy
 */
class Console extends AbstractEnvoy implements EnvoyInterface {

    
    /**
     * @inheritdoc
     */
    protected function _write($level, $message, array $context = []) {
        if ($this->_in_a_console()) {
            echo $this->_Formatter->format_for_console( $this->_Formatter->format($level, $message, $context) ) . "";
        }
    }


    /**
     * Console Loggr will nt log anything if not in a console environement.
     * Todo : check term cap.
     *
     * @return bool
     */
    private function _in_a_console() {
        if (php_sapi_name() == 'cli' && isset($_SERVER['TERM'])) {
            return true;
        }
        return false;
    }


}