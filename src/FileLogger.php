<?php

namespace derywat\logging;

use Exception;

class FileLogger extends Logger implements LoggerInterface {

	protected $filename;

	public function setLogFile(String $filename){
		$path = dirname($filename);
		if(!is_writable($path) || (file_exists($filename) && !is_writable($filename))){
			throw new Exception('Log file or directory is not writable.');
		}
		$this->filename = $filename;
		return $this;
	}

	protected function _writeToLog(LogLevel $level, String $source, String $message){
		$line = $this->_formatLogLine($level,$source,$message);
		file_put_contents($this->filename,$line,FILE_APPEND|LOCK_EX);
	}

}