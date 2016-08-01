<?php

namespace Loggr;

/**
 * @author Alexandre Robert <alex.robert@live.fr>
 */
abstract class AbstractLoggr{


   /**
    * Add context options that always interpolates with the context
    *
    * @var array
    */
   protected $_options = [
      'user' => 'unknown user',
      //'instance'     => 'lipsum', ...
      //'whatever_var' => 'wahtever'
   ];


   /**
    * Everything BELOW min level will not be logged
    * @var int
    */
   private $_min_level = 0;


   /**
    * Everything ABOVE max level will not be logged
    * @var int
    */
   private $_max_level = 100;


   /**
    * if min_lvl is defined, then all logs below that level will be ignored
    *
    * @param $min_lvl
    */
   final public function set_min_level($min_lvl){
      $this->_min_level = $min_lvl;
   }


   /**
    * @return int
    */
   final public function get_min_level(){
      return $this->_min_level;
   }


   /**
    * if max_level is defined, then all logs above that level will be ignored
    *
    * @param $max_lvl
    */
   final public function set_max_level($max_lvl){
      $this->_max_level = $max_lvl;
   }


   /**
    * @return int
    */
   final public function get_max_level(){
      return $this->_max_level;
   }


   /**
    * Options used to format logs (user name, instance,
    *
    * @param $key
    * @param $value
    */
   final public function add_option($key, $value){
      $this->_options[$key] = $value;
   }


   final public function __construct() {}


   /**
    * @inheritdoc
    */
   final public function debug($message, array $context  = []){
      $this->_log(Level::DEBUG, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final  public function info($message, array $context  = []){
      $this->_log(Level::INFO, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function notice($message, array $context  = []){
      $this->_log(Level::NOTICE, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function warning($message, array $context  = []){
      $this->_log(Level::WARNING, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function error($message, array $context  = []){
      $this->_log(Level::ERROR, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function critical($message, array $context  = []){
      $this->_log(Level::CRITICAL, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function alert($message, array $context  = []){
      $this->_log(Level::ALERT, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function emergency($message, array $context = []){
      $this->_log(Level::EMERGENCY, $message, $context);
   }



   private function _log($level, $message, array $context = []){
      if($level >= $this->_min_level && $level <= $this->_max_level){
         $this->log($level, $message, $context);
      }
   }


}