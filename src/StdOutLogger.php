<?php

namespace derywat\logging;

class StdOutLogger extends Logger implements LoggerInterface {

	protected function _writeToLog(LogLevel $level, String $source, String $message){
		$line = $this->_formatLogLine($level,$source,$message);
		file_put_contents('php://stdout', $line,FILE_APPEND|LOCK_EX);
	}

}