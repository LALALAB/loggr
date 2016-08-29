<?php

namespace Loggr;


class Channel extends AbstractHandler{


    private $_is_explicit = false;


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
    public function push(Envoy\EnvoyInterface $Envoy){

    }


    /**
     * @inheritdoc
     */
    final protected function _handle($level, $message, array $context = []){
        // TODO: Implement _handle() method.
    }


}