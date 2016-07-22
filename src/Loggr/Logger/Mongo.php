<?php

namespace Loggr\Logger;


Class Mongo extends AbstractLogger implements LoggrInterface {


   static protected $_collections = [
      'log_usage'     => [ \Loggr\Level::TIME => false, \Loggr\Level::MEMORY => false, \Loggr\Level::DEBUG => false, \Loggr\Level::INFO => true,  \Loggr\Level::NOTICE => true,  \Loggr\Level::WARNING => true,  \Loggr\Level::ERROR => true,   \Loggr\Level::CRITICAL => true,  \Loggr\Level::ALERT => true,  \Loggr\Level::EMERGENCY => true,],
      'log_debug'     => [ \Loggr\Level::TIME => false, \Loggr\Level::MEMORY => false, \Loggr\Level::DEBUG => true,  \Loggr\Level::INFO => false, \Loggr\Level::NOTICE => false, \Loggr\Level::WARNING => false, \Loggr\Level::ERROR => false,  \Loggr\Level::CRITICAL => false, \Loggr\Level::ALERT => false, \Loggr\Level::EMERGENCY => false,],

   ];


   /**
    * @inheritdoc
    */
   public function log($level, $message, array $context = []){
   }


}
