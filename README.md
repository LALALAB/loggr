Loggr
=====

Loggr is PSR-3 Loger implementation.
- It's just a loggr, so I have nothing more, funny or not, to say. 
- The cake is a lie.

### Features

- Any number of Logers can be attached to the static log.
- Loggr can be configured to log between min and max levels
- Messages are automaticly formated with the context
- File Loggr : Write logs into files. Can be configured to auto-rotate files, logs different levels in differents files...
- MySQL Loggr : Log into db. Fully configurable to map any existing table/columns. Use Only PDO connection
- HTML File Loggr : Just like the File, but add some HTML formating to review logs in a browser
- Console Loggr : For command line logs, in color


Usage
------------

        //Create and configure a file loggr
        $Fl = new \Loggr\Envoy\File();
        $Fl->set_path('./tmp/logs/');
        
        //Create a Nil loggr (that doesn nothing)
        $Nl = new \Loggr\Envoy\Nil();

        
        //Register a Loggr  
        \Loggr\Log::add_logger($Fl);
        //Register as many Loggr as you need
        \Loggr\Log::add_logger($Nl);

        
        \Loggr\Log::alert('This is going verryyyy badly...');
        
        
        //Can use also directly the loggr :
        $Fl->log(\Loggr\Level::INFO, 'Hi', ['con'=>'text']);
        //Or :  
        $Fl->info('Hi', ['con'=>'text']);

Requirements
------------

- PHP 5.4+ (use the latest version)
- At least a wrtiteable directory for the files...


Install
------------

### Composer

    {
        "require": {
            "alex-robert/loggr": "~1"        
        }
    }

### Manually

Download sources and unzip in your project directory (but who does that, really ?!)  
Their is no autloader, neither classmap file providen.


Quick Manual
------------



Licence
------------

MIT



