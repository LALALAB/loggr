<?php

namespace Loggr\Formatter;

use \Loggr\Level;

class Html extends Message implements FormatterInterface{

    
    protected $_formats = [
        Level::TIME      => "<div style='margin:auto;border-bottom : 1px solid #666; background:#B5D4F5;'> [{time}] {message} <pre>{context}</pre></div> \n",
        Level::MEMORY    => "<div style='margin:auto;border-bottom : 1px solid #666; background:#C7F2B1;'> [{time}] {message}</div> \n",
        Level::DEBUG     => "<div style='margin:auto;border-bottom : 1px solid #666; background:#C7F2B1;'> [{time}] {message}</div> \n",
        Level::NOTICE    => "<div style='margin:auto;border-bottom : 1px solid #666; background:#B5D4F5;'> [{time}] <b>{user}</b> : {message}</div> \n",
        Level::INFO      => "<div style='margin:auto;border-bottom : 1px solid #666; background:#C7F2B1;'> [{time}] <i>{message}</i> ({user})</div> \n",
        Level::WARNING   => "<div style='margin:auto;border-bottom : 1px solid #666; background:#EFF283;'> [{time}] {message}</div> \n",
        Level::ERROR     => "<div style='margin:auto;border-bottom : 1px solid #666; background:#EFF283;'> [{time}] <b>{message}</b> <pre>{context}</pre></div> \n",
        Level::ALERT     => "<div style='margin:auto;border-bottom : 1px solid #666; background:#FCBD74;'> [{time}] [*{level}*] {message} </div> \n",
        Level::CRITICAL  => "<div style='margin:auto;border-bottom : 1px solid #666; background:#FCBD74;'> [{time}] [**{level}**] <b>{message}</b></div> \n",
        Level::EMERGENCY => "<div style='margin:auto;border-bottom : 1px solid #666; background:#FEFEFE;'> [{time}] [***{level}***] <b>{message}</b></div> \n",
    ];


}