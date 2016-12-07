<?php

namespace Loggr\Formatter ;



abstract class AbstractFormatter{


    /**
     * @var \Loggr\Formatter\Helper\Context
     */
    private $_ContextFormatter;


    /**
     * @var \Loggr\Formatter\Helper\Time
     */
    private $_TimeFormatter;


    protected $_context_format = 'json';


    protected $_time_format    = 'Y-m-d h:i:s';


    protected $_microtime      = false;


    protected $_name           = '';

    /**
     * @param boolean $microtime
     * @return $this
     */
    public function set_microtime($microtime){
        $this->_microtime = $microtime;

        return $this;
    }



    /**
     * @param string $time_format
     * @return $this
     */
    public function set_time_format($time_format){
        $this->_time_format = $time_format;

        return $this;
    }


    /**
     * @param string $context_format json, serialize, callable
     * @return $this
     */
    public function set_context_format($context_format){
        $this->_context_format = $context_format;

        return $this;
    }


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
     * @return \Loggr\Formatter\Helper\Context
     */
    public function context(){
        return $this->_ContextFormatter;
    }


    /**
     * @return \Loggr\Formatter\Helper\Time
     */
    public function time(){
        return $this->_TimeFormatter;
    }



    final public function __construct(){
        $this->_ContextFormatter = new Helper\Context();
        $this->_TimeFormatter    = new Helper\Time();
    }


    /**
     * Interpolate $message variable between braces from $context
     * todo: Also interpolate with the defined options (> global context)
     *
     * @param $message
     * @param $context
     *
     * @return string
     */
    final public function interpolate($message, $context){
        $replace = [];
        if(is_array($context) || $context instanceof \Traversable){
            foreach ($context as $key => $val) {
                if (    !is_array($val)
                    && (!is_object($val) || method_exists($val, '__toString'))) {

                    $replace['{' . $key . '}'] = $val;
                }
            }
        }
        return strtr($message, $replace);
    }


    /**
     * @param $var
     *
     * @return mixed|string
     */
    public function var_export($var){
        if (is_scalar($var)) {
            return $var;
        } elseif (is_resource($var)) {
            return '';
        }

        return var_export($var, true);
    }


}