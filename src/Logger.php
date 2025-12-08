<?php

namespace derywat\logging;

use DateTime;

abstract class Logger implements LoggerInterface {

	protected LogLevel $level;
	protected null | LogLevel $maxLevel;
	protected $dateFormat = 'Y-m-d\TH:i:s.uP';

	public function __construct(){
		$this->level = LogLevel::ERROR;
		$this->maxLevel = null;
	}

	public function setLevel(LogLevel $level){
		$this->level = $level;
		return $this;
	}

	public function setMaxLevel(LogLevel $maxLevel){
		$this->maxLevel = $maxLevel;
		return $this;
	}

	public function setDateFormat(String $dateFormat){
		$this->dateFormat = $dateFormat;
	}

	public function log(LogLevel $level,String $source, String $message):void {
		if($this->_isLogLevelSufficient($level)){
			$this->_writeToLog($level,$source,$message);
		}
	}

	protected function _isLogLevelSufficient(LogLevel $level){
		return ($level->isSufficient($this->level) && $level->isNotAboveMaxLevel($this->maxLevel));
	}

	protected function _formatLogLine(LogLevel $level, String $source, String $message):String {
		$line = $this->_formatLogDate().' '.$this->_formatLogLevel($level).' '.$this->_formatLogSource($source).': '.$this->_formatLogMessage($message)."\n";
		return $line;
	}

	protected function _formatLogDate():String {
		return (new DateTime())->format($this->dateFormat.':');
	}

	protected function _formatLogLevel(LogLevel $level):String {
		$levelName = $level->getLabel();
		return "[{$levelName}]";
	}

	protected function _formatLogSource(String $source):String {
		if(trim($source) != ''){
			return "({$source})";
		}
		return '';
	}

	protected function _formatLogMessage(String $message):String {
		return $message;
	}

	abstract protected function _writeToLog(LogLevel $level, String $source, String $message);


}