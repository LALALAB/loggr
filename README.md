# Loggr

        $Fl = new \Loggr\Envoy\File();
        $Fl->set_path('./tmp/logs/');
        
        //All logs below CRITICAL will be ignored
        \Loggr\Log::set_max_level(\Loggr\Level::CRITICAL);
        
        
        \Loggr\Log::add_logger($Fl);
        \Loggr\Log::debug('this is a test', ['some' => 'context']); // > Will be ignored
        
        \Loggr\Log::alert('This is going verryyyy badly...');
        
        
        //Can use also directly the loggr :
        $Fl->log(\Loggr\Level::INFO, 'Hi', ['con'=>'text']);
        
        //Log static class can be configured with multiple Loggr classes :
        $Nl = new \Loggr\Envoy\Nil();
        
        \Loggr\Log::add_logger($Nl);
        \Loggr\Log::alert('Will be file logged and Nil logged');
