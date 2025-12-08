<?php

namespace derywat\logging;

class CompositeLogger implements LoggerInterface {


	protected $loggers = array();

	public function __construct(){}

	public function setLevel(LogLevel $level){
		foreach($this->loggers as $logger){
			$logger->setLevel($level);
		}
	}

	public function setMaxLevel(LogLevel $level){
		foreach($this->loggers as $logger){
			$logger->setMaxLevel($level);
		}
	}

	public function setDateFormat(String $dateFormat){
		foreach($this->loggers as $logger){
			$logger->setDateFormat($dateFormat);
		}
	}

	public function log(LogLevel $level,String $source, String $message):void {
		foreach($this->loggers as $logger){
			$logger->log($level,$source,$message);
		}
	}

	public function addLogger(LoggerInterface $logger){
		$this->loggers[] = $logger;
		return $this;
	}


}