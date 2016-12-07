<?php

namespace Loggr;


class Channel extends AbstractHandler{


    private $_is_explicit = false;

    private $_envoys      = [];


    public function set_explicit(){
        $this->_is_explicit = true;
    }


    public function set_implicit(){
        $this->_is_explicit = false;
    }


    public function is_explicit(){
        return $this->_is_explicit;
    }


    /**
     * Loggr constructor.
     *
     * @param $name
     */
    public function __construct($name){
        parent::__construct($name);
    }


    /**
     * @param \Loggr\Envoy\EnvoyInterface $Envoy
     */
    public function add(Envoy\EnvoyInterface $Envoy){
        $this->_envoys[] = $Envoy;
    }


    /**
     * @inheritdoc
     */
    final protected function _handle($level, $message, $context = null){
        foreach($this->_envoys as $Envoy){
            $Envoy->log($level, $message, $context);
        }
    }


}