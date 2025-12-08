<?php

namespace derywat\logging;

class StdErrLogger extends Logger implements LoggerInterface {

	protected function _writeToLog(LogLevel $level, String $source, String $message){
		$line = $this->_formatLogLine($level,$source,$message);
		file_put_contents('php://stderr', $line,FILE_APPEND|LOCK_EX);
	}

}