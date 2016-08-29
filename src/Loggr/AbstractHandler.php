<?php

namespace Loggr;

use \Loggr\Level;

/**
 * @author Alexandre Robert <alex.robert@live.fr>
 */
abstract class AbstractHandler {

    /**
     * @var string
     */
    protected $_name = '';


    /**
     * @param $name
     */
    final public function set_name($name){
        $this->_name = $name;
    }


    /**
     * @return string
     */
    final public function get_name(){
        return $this->_name;
    }


    /**
     * AbstractHandler constructor.
     *
     * @param $name
     */
    public function __construct($name){
        $this->_name = $name;
    }


    /**
     * @inheritdoc
     */
    final public function debug($message, array $context  = []){
        $this->_handle(Level::DEBUG, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final  public function info($message, array $context  = []){
        $this->_handle(Level::INFO, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function notice($message, array $context  = []){
        $this->_handle(Level::NOTICE, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function warning($message, array $context  = []){
        $this->_handle(Level::WARNING, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function error($message, array $context  = []){
        $this->_handle(Level::ERROR, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function critical($message, array $context  = []){
        $this->_handle(Level::CRITICAL, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function alert($message, array $context  = []){
        $this->_handle(Level::ALERT, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function emergency($message, array $context = []){
        $this->_handle(Level::EMERGENCY, $message, $context);
    }


    /**
     * @inheritdoc
     */
    final public function log($level, $message, array $context = []){
        $this->_handle($level, $message, $context);
    }


    /**
     * @param       $level
     * @param       $message
     * @param array $context
     */
    abstract protected function _handle($level, $message, array $context = []);


}