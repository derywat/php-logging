# Simple PHP logging library.

> [!CAUTION]  
> LoggerInterface and classes methods are NOT STABLE until anounced.

## Single target loggers

Single target loggers allow logging to single target - file, stdOut, strErr.

###  StdOutLogger & StdErrLogger

StdOutLogger class allows logging to stdOut.
StdErrLogger class allows logging to stdErr.

```php
use derywat\logging\LogLevel;
use derywat\logging\StdOutLogger;

$logger = (new StdOutLogger())->setLevel(LogLevel::INFO);

//log something...
$logger->log(LogLevel::INFO,'main process','main process example log message.');
```

###  FileLogger

FileLogger class allows logging to file.

```php
use derywat\logging\FileLogger;
use derywat\logging\LogLevel;

$logger = (new FileLogger())->setLogFile('var/log/service.info.log')->setLevel(LogLevel::INFO);

//log something...
$logger->log(LogLevel::INFO,'main process','main process example log message.');
```

## Multiple target loggers

### CompositeLogger

CompositeLogger class allows logging to multiple single target loggers.

```php
use derywat\logging\CompositeLogger;
use derywat\logging\FileLogger;
use derywat\logging\LogLevel;
use derywat\logging\StdErrLogger;
use derywat\logging\StdOutLogger;

$logger = ((new CompositeLogger())

	//StdOut logger - logging levels from INFO to WARN
	->addLogger((new StdOutLogger())->setLevel(LogLevel::INFO)->setMaxLevel(LogLevel::WARN))

	//StdErr logger - logging levels from ERROR
	->addLogger((new StdErrLogger())->setLevel(LogLevel::ERROR))

	//File logger - logging levels from INFO
	->addLogger((new FileLogger())->setLogFile('var/log/service.info.log')->setLevel(LogLevel::INFO))

	//File logger - logging levels from WARN
	->addLogger((new FileLogger())->setLogFile('var/log/service.warn.log')->setLevel(LogLevel::WARN))

	//File logger - logging levels from ERROR
	->addLogger((new FileLogger())->setLogFile('var/log/service.error.log')->setLevel(LogLevel::ERROR))
);

//log something...
$logger->log(LogLevel::INFO,'main process','main process example log message.');
```

## Adding loggers

New loggers can be implemented by extending abstract Logger class.

```php

class NewLogger extends Logger implements LoggerInterface {

	protected function _writeToLog(LogLevel $level, String $source, String $message){
		//default log line formatting defined in Logger class
		$line = $this->_formatLogLine($level,$source,$message);

		//put code writing/sending $line to log here

	}

}
```

## Loggers methods

### setLevel

Sets minimal logging level (inclusive)

```php
//sets minimum log level to WARN, lower levels (DEBUG, INFO) are not written to log
$logger->setLevel(LogLevel::WARN);
```

### setMaxLevel

Sets maximal logging level (inclusive)

```php
//sets maximum log level to WARN, higher levels (ERROR, FATAL) are not written to log
$logger->setMaxLevel(LogLevel::WARN);
```

### setDateFormat

Sets date format for log lines.  
Expected format string is the same as for use with DateTime.format() method.  
Default Logger class format: 'Y-m-d\TH:i:s.uP'.

```php
	$logger->setDateFormat('Y-m-d H:i:s');
```

### log

Log method writes line to log.

```php
$logger->log(LogLevel::INFO,'main process','example log message');
```

Log output format:

```
2025-12-09T14:41:52.362406+01:00: [info] (main process): example log message
```

## LogLevel

LogLevel enum class defines logging levels.

Levels / log file representation
- DEBUG / [debug]
- INFO / [info]
- WARN / [warning]
- ERROR / [error]
- FATAL / [fatal]
