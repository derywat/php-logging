<?php

namespace derywat\logging;

interface LoggerInterface {

	public function __construct();

	public function setLevel(LogLevel $level);

	public function setMaxLevel(LogLevel $maxLevel);
	
	public function setDateFormat(String $dateFormat);

	public function log(LogLevel $level,String $source, String $message):void;

}