<?php

namespace Loggr\Envoy;


Class File extends \Loggr\AbstractLoggr implements \Loggr\LoggrInterface {


   protected $_files = [
      'all'     => [ \Loggr\Level::TIME => false, \Loggr\Level::MEMORY => false, \Loggr\Level::DEBUG => false, \Loggr\Level::INFO => true,  \Loggr\Level::NOTICE => true,  \Loggr\Level::WARNING => true,  \Loggr\Level::ERROR => true,   \Loggr\Level::CRITICAL => true,  \Loggr\Level::ALERT => true,  \Loggr\Level::EMERGENCY => true,],
      'debug'   => [ \Loggr\Level::TIME => false, \Loggr\Level::MEMORY => false, \Loggr\Level::DEBUG => true,  \Loggr\Level::INFO => false, \Loggr\Level::NOTICE => false, \Loggr\Level::WARNING => false, \Loggr\Level::ERROR => false,  \Loggr\Level::CRITICAL => false, \Loggr\Level::ALERT => false, \Loggr\Level::EMERGENCY => false,],
      'error'   => [ \Loggr\Level::TIME => false, \Loggr\Level::MEMORY => false, \Loggr\Level::DEBUG => false, \Loggr\Level::INFO => false, \Loggr\Level::NOTICE => false, \Loggr\Level::WARNING => false, \Loggr\Level::ERROR => true,   \Loggr\Level::CRITICAL => true,  \Loggr\Level::ALERT => true,  \Loggr\Level::EMERGENCY => true,],
      'perf'    => [ \Loggr\Level::TIME => true,  \Loggr\Level::MEMORY => true,  \Loggr\Level::DEBUG => false, \Loggr\Level::INFO => false, \Loggr\Level::NOTICE => false, \Loggr\Level::WARNING => false, \Loggr\Level::ERROR => false,  \Loggr\Level::CRITICAL => false, \Loggr\Level::ALERT => false, \Loggr\Level::EMERGENCY => false,],
   ];

   protected $_ext = 'log';


   protected $_path = '';


   /**
    * Will rotate log file based on a time span
    *
    * $_rotation = ['hourly', 12]; // Rotate Log every 12 hours
    * $_rotation = ['daily', 1];   // Rotate Log every days
    * $_rotation = ['daily', 3];   // Rotate Log every 3 days
    *
    * @todo file rotation (yearly/monthly/weekly/daily/hourly/minutely)
    * @todo make accessors to set (get not needed)
    * @var array
    */
   protected $_rotation = ['hourly', 12];


   /**
    * Same as for log rotation, but based on file size instead of a time span.
    * Chunk size is defined in Kb.
    *
    * @var int
    */
   protected $_chunk_size = 2048;


   /**
    * @var array
    */
   protected $_format = [
      \Loggr\Level::TIME      => "[{time}] - [{message}] \n",
      \Loggr\Level::MEMORY    => "[{time}] - [{message}] \n",
      \Loggr\Level::DEBUG     => "[{time}] - {message} {context} \n",
      \Loggr\Level::NOTICE    => "[{time}] - {message} \n",
      \Loggr\Level::INFO      => "[{time}] [{level}] - {message} \n",
      \Loggr\Level::WARNING   => "[{time}] [{level}] -  **{message}** \n",
      \Loggr\Level::ERROR     => "[{time}] [{level}] -  **{message}**  {context} \n",
      \Loggr\Level::ALERT     => "[{time}] [*{level}*] - {message}     {context} \n",
      \Loggr\Level::CRITICAL  => "[{time}] [**{level}**] - {message}   {context} \n",
      \Loggr\Level::EMERGENCY => "[{time}] [***{level}***] - {message} {context} \n",
   ];


   /**
    * @param $path where the logs files are saved
    */
   public function set_path($path) {
      $this->_path = preg_replace('/\/$/', '', $path);
   }


   /**
    * @param bool|array $rotation
    */
   public function set_rotation($rotation) {
      $this->_rotation = $rotation;
   }


   /**
    * @param       $name
    * @param array $levels
    */
   public function set_file($name, array $levels){
      $this->_files[$name] = $levels;
   }


   /**
    * @param array $files
    */
   public function set_files(array $files){
      $this->_files = $files;
   }


   /**
    * @param $level
    * @param $template
    */
   public function set_format($level, $template){
      $this->_format[$level] = $template;
   }


   /**
    * @inheritdoc
    */
   public function log($level, $message, array $context = []) {

      foreach ($this->_files as $file_name => $opt) {
         if ($opt[$level]) {

            $file_path = realpath($this->_path) . '/' . $file_name . '.' . $this->_ext;

            if (   file_exists($file_path)
                && ($this->_do_time_rotation($file_path) || $this->_do_time_rotation($file_path)) ) {
               rename($file_path, str_replace($file_name . '.' . $this->_ext, $file_name . '_' . date('Ymdhi')  . '.' . $this->_ext, $file_path));
            }

            $flag = FILE_APPEND;
            file_put_contents($file_path, $this->_format($level, $message, $context), $flag);
         }
      }

   }


   /**
    * @param $level
    * @param $message
    * @param $context
    * @return mixed|null
    */
   protected function _format($level, $message, $context) {
      $format = $this->_format[$level];
      if ($format) {

         $this->_options['level']   = \Loggr\Level::get_name($level);//Level to string
         $this->_options['time']    = date('Y-m-d h:i:s') . '.' . str_pad(array_pop(explode('.', microtime(true))), 6, 0, STR_PAD_LEFT);
         $this->_options['message'] = $message;
         $this->_options['context'] = ($context ? "\n" . var_export($context, true) : "");

         $log_message = $format;
         foreach($this->_options as $option => $value){
            $log_message = str_replace('{' . $option . '}', $value, $log_message);
         }
         return $log_message;
      }
      return null;
   }



   /**
    * Check if the given file should be rotated based on a time span
    *
    * @param string $file_path
    *
    * @return bool
    */
   protected function _do_time_rotation($file_path) {
      if ($this->_rotation) {
         $file_time = filemtime($file_path);
         $curr_time = time();

         switch ($this->_rotation[0]) {
            case 'hourly'   :  $time_span = (3600 * $this->_rotation[1] );
               break;
            case 'daily'    :  $time_span = (3600 * 24 * $this->_rotation[1] );
               break;
            case 'minutely' :  $time_span = (60 * $this->_rotation[1] );
               break;
            default         :  $time_span = (3600 * 24 ); //Rotate every day
         }
         return ( $curr_time - $time_span ) > $file_time ? true : false;
      }
      return false;
   }


   /**
    * Check if the given file should be rotated based on it's size
    *
    * @param  string $file_path
    *
    * @return bool
    */
   protected function _do_size_rotation($file_path){
      return (filesize($file_path) > $this->_chunk_size * 1000) ? true : false;
   }

}