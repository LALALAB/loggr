<?php

namespace Loggr\Formatter;

use \Loggr\Level;


class Console extends Message implements FormatterInterface{

    protected $_formats = [
        Level::TIME      => "{time} :b {message} \n",
        Level::MEMORY    => "{time} :b {message} \n",
        Level::DEBUG     => "{time} :b {message} :rst {context} \n",
        Level::NOTICE    => "{time} :white {message} \n",
        Level::INFO      => "{time} :cyan {message} \n",
        Level::WARNING   => "{time} :yellow {message} \n",
        Level::ERROR     => "{time} :bg:red {message} :rst {context} \n",
        Level::ALERT     => "{time} :red {message} \n",
        Level::CRITICAL  => "{time} :b :bg:white :yellow {message} :rst :white {context} \n",
        Level::EMERGENCY => "{time} :b :bg:white :red {message} :rst :white {context} \n",
    ];


    /**
     * Colors codes (0 => foreground, 1 => background)
     * @var array
     */
    private static $_colors_codes = [
        'default'       => ['39','49' ],
        'black'         => ['30','40' ],
        'red'           => ['31','41' ],
        'green'         => ['32','42' ],
        'yellow'        => ['33','43' ],
        'blue'          => ['34','44' ],
        'magenta'       => ['35','45' ],
        'cyan'          => ['36','46' ],
        'light-gray'    => ['37','47' ],
        'dark-gray'     => ['90','100'],
        'light-red'     => ['91','101'],
        'light-green'   => ['92','102'],
        'light-yellow'  => ['93','103'],
        'light-blue'    => ['94','104'],
        'light-magenta' => ['95','105'],
        'light-cyan'    => ['96','106'],
        'white'         => ['97','107'],
    ];


    /**
     * Format codes
     * @var array
     */
    private static $_text_codes = [
        'reset'     => '0',
        'bold'      => '1',
        'dim'       => '2',
        'underline' => '4',
        'blink'     => '5',
        'reverse'   => '7',
        'hidden'    => '8',
    ];


    /**
     * String formaters (easier, more readable than \e[33m...
     * @var array
     */
    private static $_text_formats = [
        ':rst'     =>  'reset'         ,
        ':reset'   =>  'reset'         ,
        ':end'     =>  'reset'         ,
        ':bold'    =>  'bold'          ,
        //':dim'     =>  'dim'           , //Doesn't Work on xterm
        ':udl'     =>  'underline'     ,
        ':blk'     =>  'blink'         ,
        ':rev'     =>  'reverse'       ,
        ':hid'     =>  'hidden'        ,
        ':dflt'    =>  'default'       ,
        ':def'     =>  'default'       ,
        ':u'       =>  'underline'     ,
        ':b'       =>  'bold'          ,

    ];


    /**
     * Color string formatters
     * @var array
     */
    private static $_color_formats = [
        ':black'   =>  'black'         ,
        ':blk'     =>  'black'         ,
        ':red'     =>  'red'           ,
        ':green'   =>  'green'         ,
        ':grn'     =>  'green'         ,
        ':yellow'  =>  'yellow'        ,
        ':ylw'     =>  'yellow'        ,
        ':blue'    =>  'blue'          ,
        ':blu'     =>  'blue'          ,
        ':mga'     =>  'magenta'       ,
        ':cyan'    =>  'cyan'          ,
        ':cya'     =>  'cyan'          ,
        ':gray'   =>   'gray'          ,
        ':white'   =>  'white'         ,
        ':wit'     =>  'white'         ,
    ];


    /**
     * To use light color, background colors...
     * @var array
     */
    private static $_color_mod = [
        ':bg'      =>  'background'    ,
        ':fg'      =>  'foreground'    ,
        ':light'   =>  'light'         ,
        ':l'       =>  'light'         ,
        ':dark'    =>  'dark'          ,

    ];


    /**
     * Take a string with console formatters like :
     *   :red Hello :blue World
     * and format it for display in a terminal.
     * The space right after the formater is optional, and it is removed by the function.
     *
     * @param $string
     *
     * @return string
     */
    public function format_for_console($string){

        $term_str  = "\e[0m";

        $split_pattern = implode('|', array_keys(array_merge(self::$_color_mod, self::$_color_formats, self::$_text_formats)));
        $string        = preg_replace("#(". $split_pattern .")(\s)#", "$1", $string);
        $tokenized_str = preg_split  ("#(". $split_pattern .")#i", $string, 0, PREG_SPLIT_DELIM_CAPTURE);

        $cl_mode = 0; //Foreground
        $cl_lght = '';

        for($i=0; $i<count($tokenized_str); $i++){

            $token = $tokenized_str[$i];

            if($token && strpos($token, ':') === 0) {

                if (isset(self::$_text_formats[$token])) {

                    $term_str .= "\e[".self::$_text_codes[self::$_text_formats[$token]]."m";

                } else if (isset(self::$_color_formats[$token])){

                    $code      = self::$_colors_codes[$cl_lght.substr($token, 1)][$cl_mode];

                    $term_str .= $code ? "\e[".$code."m" : "\e[0m";

                    $cl_mode = 0; $cl_lght = '';

                } else if (isset(self::$_color_mod[$token])) {

                    switch(self::$_color_mod[$token]){
                        case 'background' : $cl_mode = 1; break;
                        case 'foreground' : $cl_mode = 0; break;
                        case 'light'      : $cl_lght = 'light-'; break;
                        case 'dark'       : $cl_lght = 'dark-';  break;
                    }

                }
            }else if($token){

                $term_str .= $token;
            }

        }

        $term_str .= "\e[0m";
        return $term_str;
    }

}