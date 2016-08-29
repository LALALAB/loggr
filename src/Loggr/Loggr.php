<?php

namespace Loggr;


class Loggr extends AbstractHandler{


    private $_channels  = [];


    /**
     *
     * handle $Loggr->channel_name()->log(...) notation
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
     public function __call($name, $arguments){

        if(isset($this->_channels[$name])){
            return $this->_channels[$name];
        }else if (isset($this->_channels['default'])) {
            return $this->_channels['default'];
        }else{
            //error
        }

    }


    /**
     * @param Loggr $Loggr
     */
    public function add_channel(Channel $Channel){
        $this->_channels[$Channel->get_name()] = $Channel;
    }


    /**
     * Add a Loggr class
     * @param LoggrInterface $Loggr
     * @param string $channel
     */
    public function add_envoy(Envoy\EnvoyInterface $Envoy, $channel = 'default'){
        if( !isset($this->_channels[$channel]) ){
            $this->_channels[$channel] = new Channel($channel);
        }

        $this->_channels[$channel]->add($Envoy);
    }


    /**
     * @param       $level
     * @param       $message
     * @param array $context
     * @param array $channels
     */
    protected function _handle($level, $message, array $context = [], array $channels = []){
        $this->_notify($level, $message, $context, $channels);
    }


    /**
     * @param $level
     * @param $message
     * @param $context
     */
    private function _notify($level, $message, $context = [], array $channels = []){
        if(empty($channels)){
            $channels = self::_get_implicit_channels();
        }

        foreach($channels as $name){
            if(isset($this->_channels[$name])){

                $this->_channels[$name]->log($level, $message, $context);
            }
        }
    }


    private function _get_implicit_channels(){

        $channels = [];

        foreach($this->_channels as $Channel){
            if(!$Channel->is_explicit()){
                $channels[] = $Channel->get_name();
            }
        }
        return $channels;
    }


}