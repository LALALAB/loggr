<?php

namespace Loggr\Envoy;

use \Loggr\Level;

/**
 * @author Alexandre Robert <alex.robert@live.fr>
 */
abstract class AbstractEnvoy{


   /**
    * Add context options that always interpolates with the context
    *
    * @var array
    */
   protected $_options = [
      //'user'         => 'unknown user',
      //'instance'     => 'lipsum', ...
      //'whatever_var' => 'wahtever'
   ];


   /**
    * @var \Loggr\Formatter\AbstractFormatter;
    */
   protected $_Formatter = null;


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
    * @var string
    */
   private $_name = '';
   


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
    * If set to true, context will be displayed as a JSON string.
    * Will be a var_export if not (default)
    *
    * @param bool $context_as_json
    */
   final public function set_context_as_json($context_as_json){
      $this->_context_as_json = $context_as_json;
   }


   /**
    *
    * @return \Loggr\Formatter\FormatterInterface
    */
   public function get_formatter(){
      if(   $this->_Formatter === null
         && $class = $this->_which_formatter()){

         $this->_Formatter = new $class;
      }

      $this->_Formatter->set_name($this->get_name());

      return $this->_Formatter;
   }


   /**
    * @param \Loggr\Formatter\FormatterInterface $Formatter
    */
   public function set_formatter(\Loggr\Formatter\FormatterInterface $Formatter ){

      $this->_Formatter = $Formatter;
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


   /**
    * AbstractEnvoy constructor.
    *
    * @param $name Channel name
    */
   final public function __construct($name) {
      //Setup the base formatter for this logger, in case no other in settup afterward.
      $this->get_formatter();
   }


   /**
    * @inheritdoc
    */
   final public function debug($message, array $context  = []){
      $this->_handle_write(Level::DEBUG, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final  public function info($message, array $context  = []){
      $this->_handle_write(Level::INFO, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function notice($message, array $context  = []){
      $this->_handle_write(Level::NOTICE, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function warning($message, array $context  = []){
      $this->_handle_write(Level::WARNING, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function error($message, array $context  = []){
      $this->_handle_write(Level::ERROR, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function critical($message, array $context  = []){
      $this->_handle_write(Level::CRITICAL, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function alert($message, array $context  = []){
      $this->_handle_write(Level::ALERT, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function emergency($message, array $context = []){
      $this->_handle_write(Level::EMERGENCY, $message, $context);
   }


   /**
    * @inheritdoc
    */
   final public function log($level, $message, array $context = []){
      $this->_handle_write($level, $message, $context);
   }


   /**
    * @param       $level
    * @param       $message
    * @param array $context
    *
    * @return mixed
    */
   abstract protected function _write($level, $message, array $context = []);


   /**
    * @param       $level
    * @param       $message
    * @param array $context
    */
   private function _handle_write($level, $message, array $context = []){
      if($level >= $this->_min_level && $level <= $this->_max_level){
         $this->_write($level, $message, $context);
      }
   }


   /**
    * @return string
    */
   private function _which_formatter(){
      $class = '\\' . str_replace('Envoy', 'Formatter', get_class($this));

      if(class_exists($class) && isset(class_implements($class, true)['Loggr\Formatter\FormatterInterface']) ){
         return $class;
      }

      //Default message formating (context interpolation)
      return '\\Loggr\\Formatter\\Message';
   }



}