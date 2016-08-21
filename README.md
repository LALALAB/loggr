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
        "minimum-stability": "dev",
        "require": {
            "alex-robert/loggr": "~2"        
        }
    }

### Manually

Download sources and unzip in your project directory (but who does that, really ?!)  
Their is no autloader, neither classmap file providen.


Quick Manual
------------

### File Formatter exemple

    $Fl = new \Loggr\Envoy\File();
    $Fl->set_path('/tmp/logs/');
    $Fl->get_formatter()
            ->set_format(\Loggr\Level::DEBUG, "{level} ::: {time} - {message} {context} \n")
            ->set_format('default', "{level} :: {time} - {message} \n")
            ->set_time_format('Y-m-d h:i:s')
            ->set_microtime(true)
            ->set_context_format('json');
    
    $Fl->set_min_level(\Loggr\Level::INFO);
    $Fl->info('Hello {to}', ['to'=>'World']);
    $Fl->debug('Not logged, below min level');
    
    
### MySQL Loggr exemple

    $Ml = new \Loggr\Envoy\MySQL();
    $Ml->set_connection(new PDO('mysql:host=localhost;dbname=test', 'logger'));
    $Ml->set_table_name('logs');
    
    //Bind context and basics ('message', 'level', 'context', 'time') keys to DB columns
    $Ml->bind_column_names([
        'time'    => 'created_at',
        'level'   => 'lvl',
        'foo'     => 'bar'
    ]);
    
    //Will bind "description" key (in the context) to description column
    $Ml->bind_column('description');
    
    $Ml->debug('Test', ['description' => 'This is a test.', 'bar' => 'Just inside the context', 'foo' => 'Goes in bar column']);



Licence
------------

MIT



