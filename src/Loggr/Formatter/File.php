<?php

namespace Loggr\Formatter;

use \Loggr\Level;

class File extends Message implements FormatterInterface{

    protected $_formats = [
        Level::TIME      => "{name} [{time}] - [{message}] \n",
        Level::MEMORY    => "{name} [{time}] - [{message}] \n",
        Level::DEBUG     => "{name} [{time}] - {message} {context} \n",
        Level::NOTICE    => "{name} [{time}] - {message} \n",
        Level::INFO      => "{name} [{time}] [{level}] - {message} \n",
        Level::WARNING   => "{name} [{time}] [{level}] -  **{message}** \n",
        Level::ERROR     => "{name} [{time}] [{level}] -  **{message}**  {context} \n",
        Level::ALERT     => "{name} [{time}] [*{level}*] - {message}     {context} \n",
        Level::CRITICAL  => "{name} [{time}] [**{level}**] - {message}   {context} \n",
        Level::EMERGENCY => "{name} [{time}] [***{level}***] - {message} {context} \n",
    ];


}