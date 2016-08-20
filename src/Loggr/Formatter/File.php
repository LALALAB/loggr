<?php

namespace Loggr\Formatter;

use \Loggr\Level;

class File extends Message implements FormatterInterface{

    protected $_formats = [
        Level::TIME      => "[{time}] - [{message}] \n",
        Level::MEMORY    => "[{time}] - [{message}] \n",
        Level::DEBUG     => "[{time}] - {message} {context} \n",
        Level::NOTICE    => "[{time}] - {message} \n",
        Level::INFO      => "[{time}] [{level}] - {message} \n",
        Level::WARNING   => "[{time}] [{level}] -  **{message}** \n",
        Level::ERROR     => "[{time}] [{level}] -  **{message}**  {context} \n",
        Level::ALERT     => "[{time}] [*{level}*] - {message}     {context} \n",
        Level::CRITICAL  => "[{time}] [**{level}**] - {message}   {context} \n", 
        Level::EMERGENCY => "[{time}] [***{level}***] - {message} {context} \n",
    ];


}