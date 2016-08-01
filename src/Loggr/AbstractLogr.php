<?php

namespace Loggr;

/**
 * @author Alexandre Robert <alex.robert@live.fr>
 */
abstract class AbstractLogger implements LoggrInterface{


   protected $_options = [
      'user' => 'unknown user',
      //'instance' => 'lipsum', ...
      //'whatever_var' => 'wahtever'
   ];


   /**
    * Options used to format logs (user name, instance,
    *
    * @param $key
    * @param $value
    */
   final public function add_option($key, $value){
      $this->_options[$key] = $value;
   }


   final public function __construct() {

   }


   final public function debug($message, array $context  = []){
      $this->log(Level::DEBUG, $message, $context);
   }


   final  public function info($message, array $context  = []){
      $this->log(Level::INFO, $message, $context);
   }


   final public function notice($message, array $context  = []){
      $this->log(Level::NOTICE, $message, $context);
   }


   final public function warning($message, array $context  = []){
      $this->log(Level::WARNING, $message, $context);
   }


   final public function error($message, array $context  = []){
      $this->log(Level::ERROR, $message, $context);
   }


   final public function critical($message, array $context  = []){
      $this->log(Level::CRITICAL, $message, $context);
   }


   final public function alert($message, array $context  = []){
      $this->log(Level::ALERT, $message, $context);
   }


   final public function emergency($message, array $context = []){
      $this->log(Level::EMERGENCY, $message, $context);
   }


}