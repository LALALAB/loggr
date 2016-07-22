<?php

namespace Loggr;


class Html extends File{


   protected $_ext   = 'htm';
   protected $_chunk = 4096;


   protected $_format = [
      \Loggr\Level::DEBUG     => "<div style='margin:auto;border-bottom : 1px solid #666; background:#B5D4F5;'> [{{time}}] {{message}} <pre>{{context}}</pre></div> \n",
      \Loggr\Level::TIME      => "<div style='margin:auto;border-bottom : 1px solid #666; background:#C7F2B1;'> [{{time}}] {{message}}</div> \n",
      \Loggr\Level::MEMORY    => "<div style='margin:auto;border-bottom : 1px solid #666; background:#C7F2B1;'> [{{time}}] {{message}}</div> \n",
      \Loggr\Level::NOTICE    => "<div style='margin:auto;border-bottom : 1px solid #666; background:#B5D4F5;'> [{{time}}] <b>{{user}}</b> : {{message}}</div> \n",
      \Loggr\Level::INFO      => "<div style='margin:auto;border-bottom : 1px solid #666; background:#C7F2B1;'> [{{time}}] <i>{{message}}</i> ({{user}})</div> \n",
      \Loggr\Level::WARNING   => "<div style='margin:auto;border-bottom : 1px solid #666; background:#EFF283;'> [{{time}}] {{message}}</div> \n",
      \Loggr\Level::ERROR     => "<div style='margin:auto;border-bottom : 1px solid #666; background:#EFF283;'> [{{time}}] <b>{{message}}</b> <pre>{{context}}</pre></div> \n",
      \Loggr\Level::ALERT     => "<div style='margin:auto;border-bottom : 1px solid #666; background:#FCBD74;'> [{{time}}] [*{{level}}*] {{message}} </div> \n",
      \Loggr\Level::CRITICAL  => "<div style='margin:auto;border-bottom : 1px solid #666; background:#FCBD74;'> [{{time}}] [**{{level}}**] <b>{{message}}</b></div> \n",
      \Loggr\Level::EMERGENCY => "<div style='margin:auto;border-bottom : 1px solid #666; background:#FEFEFE;'> [{{time}}] [***{{level}}***] <b>{{message}}</b></div> \n",
   ];


}