Loggr
=====

Loggr is PSR-3 Loger implementation.
- It's just a loggr, so I have nothing more, funny or not, to say. 
- The cake is a lie.

### Features

- Any number of handlers can log at once.
- Different handlers can be configured to log between min and max levels
- Messages are automaticly formated with the context
- File Loggr : Write logs into files. Can be configured to auto-rotate files, logs different levels in differents files
- MySQL Loggr : Log into db. Fully configurable to map any existing table. Require a PDO connection
- HTML File Loggr : Just like the File, but add some HTML formating to review logs in a browser
- Console Loggr : For command line logs, in color


Usage
------------

#### Direct logging : 
````php
//Create and configure a file loggr
$Fl = new \Loggr\Envoy\File();
$Fl->set_path('./tmp/logs/');

//Create a Nil loggr (that doesn nothing)
$Nl = new \Loggr\Envoy\Nil();

//log takes 3 args : level, message and context (optional)
$Fl->log(\Loggr\Level::INFO, 'Hi', ['con'=>'text']);

//or you can use the shortcut methods to avoid passing the level
$Fl->info('Hi', ['con'=>'text']);
````

#### Unsing the static class : 

```php
//Register a log handler (called an envoy here)  
\Loggr\Log::add_envoy($Fl);
//Register as many Loggr as you need
\Loggr\Log::add_envoy($Nl);
\Loggr\Log::add_envoy(new \Loggr\Envoy\MySQL());


//This will be logged to a File and in Mysql
\Loggr\Log::alert('This is going verryyyy badly...');
```

#### Using the Loggr Class : 

```php
$Log = new \Loggr\Loggr();
$Log->add_envoy(new \Loggr\Envoy\File());
$Log->debug('Debug message', ['Some', 'Context']);

```

Requirements
------------

- PHP 5.4+ (use the latest version)
- At least a wrtiteable directory for the files...


Install
------------

### Composer
```json
{
    "minimum-stability": "dev",
    "require": {
        "alex-robert/loggr": "~2"        
    }
}
```

### Manually

Download sources and unzip in your project directory (but who does that, really ?!)  

Quick Manual
------------

### File Formatter exemple

```php
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
```    
    
### MySQL Loggr exemple

```php
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
``` 

### Channel Logging

A channel is a stack of log handlers. It works with the same methods as a simple Loggr, but you can add multiple handlers to a channel, so you don't haveto create multiples instances of `Loggr`.  
It can be usefull to create a channel for `api_calls`, another for `internals_errors` or even a `dev channel.  
Channels works with static logging or with the Loggr class.  

Instead of doing : 

```php
$ApiLog = new \Loggr\Loggr();
//Setup envoys...
$ApiLog->debug('Api call to ' . $url, $request_data);


$DebugLog = new \Loggr\Loggr();
//Setup envoys
$DebugLog->debug('Debug message', ['Some', 'Context']);
```

Use channels : 

```php

$Fl1 = new \Loggr\Envoy\File();
$Fl1->set_path(__DIR__ . '/tmp/logs/');

$Fl2 = new \Loggr\Envoy\File();
$Fl2->set_path(__DIR__ . '/tmp/logs/');

$Fl3 = new \Loggr\Envoy\File();
$Fl3->set_path(__DIR__ . '/tmp/logs/');

$Fl4 = new \Loggr\Envoy\File();
$Fl4->set_path(__DIR__ . '/tmp/logs/');

//Constructor get a name for the channel
$ApiChannel = new Channel('api_call');
$ApiChannel->add($Fl2);
$ApiChannel->add($Fl3);
$ApiChannel->add($Fl4);

$Log->add_channel($ApiChannel)

$Log->add_envoy($Fl1);
// > add $Fl1 to a default channel called 'implicit'

$Log->debug('debug route', [$request_data], ['api_call']);
// > log only to $Fl2, $Fl3 and $Fl4

//Calling without specifiing a channel will log to every implicit channels : 
$Log->debug('debug route', [$request_data]); 
// > log in $Fl1,2,3 and 4.

//Set the channel explicit, so it log only when explicitly called
$ApiChannel->set_explicit();


$Log->debug('Debug Message'); 
// > log in only in $Fl1, as the default channel is not explicit

$Log->debug('Debug Message', null, ['api_call']); 
// > log only in $ApiChannel

```

Roadmap
------------

- Mongo Logger
- Redis Logger
- Maybe remove console Loggr that isn't really conveniant here ? 
- Finish and commit unit tests


Licence
------------

MIT



