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
        call_user_func_array([$this, '_handle'], array_merge([Level::DEBUG], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final  public function info($message, array $context  = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::INFO], func_get_args()));

    }


    /**
     * @inheritdoc
     */
    final public function notice($message, array $context  = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::NOTICE], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final public function warning($message, array $context  = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::WARNING], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final public function error($message, array $context  = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::ERROR], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final public function critical($message, array $context  = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::CRITICAL], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final public function alert($message, array $context  = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::ALERT], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final public function emergency($message, array $context = []){
        call_user_func_array([$this, '_handle'], array_merge([Level::EMERGENCY], func_get_args()));
    }


    /**
     * @inheritdoc
     */
    final public function log($level, $message, array $context = []){
        call_user_func_array([$this, '_handle'], func_get_args());
    }


    /**
     * @param       $level
     * @param       $message
     * @param array $context
     * @param array $channels
     */
    abstract protected function _handle($level, $message, array $context = []);


}