<?php

namespace Loggr\Envoy;

use \Loggr\Level;

Class File extends AbstractEnvoy implements EnvoyInterface {


   protected $_files = [
      'all'     => [ Level::INFO ,      Level::NOTICE,   Level::WARNING ,  Level::ERROR ,   Level::CRITICAL ,  Level::ALERT ,  Level::EMERGENCY],
      'debug'   => [ Level::TIME ,  Level::MEMORY ,    Level::DEBUG],
      'error'   => [ Level::ERROR , Level::CRITICAL ,  Level::ALERT ,   Level::EMERGENCY],
      'perf'    => [ Level::TIME ,  Level::MEMORY],
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
   public function add_file($name, array $levels){
      $this->_files[$name] = $levels;
   }


   /**
    * @param array $files
    */
   public function set_files(array $files){
      $this->_files = $files;
   }


   /**
    * @inheritdoc
    */
   protected function _write($level, $message, $context = null) {


      foreach ($this->_files as $file_name => $opt) {



         if ( in_array($level, $opt) ) {

            $file_path = realpath($this->_path) . '/' . $file_name . '.' . $this->_ext;

            if (   file_exists($file_path)
                && ($this->_do_time_rotation($file_path) || $this->_do_size_rotation($file_path)) ) {
               rename($file_path, str_replace($file_name . '.' . $this->_ext, $file_name . '_' . date('Ymdhi')  . '.' . $this->_ext, $file_path));
            }

            file_put_contents(   $file_path,
                                 $this->_Formatter->format($level, $message, $context),
                                 FILE_APPEND
            );
         }
      }

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