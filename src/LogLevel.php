<?php

namespace derywat\logging;

enum LogLevel: int {

	case DEBUG = 1000;
	case INFO  = 2000;
	case WARN  = 3000;
	case ERROR = 4000;
	case FATAL = 5000;

    public function getLabel(): string {
        return match($this) {
            self::DEBUG => 'debug',
            self::INFO  => 'info',
            self::WARN  => 'warning',
            self::ERROR => 'error',
			self::FATAL => 'fatal'
        };
    }

	public function isSufficient(self $targetLevel){
		return $this->value >= $targetLevel->value;
	}

	public function isNotAboveMaxLevel(null|self $maxLevel){
		if(isset($maxLevel)){
			return $this->value <= $maxLevel->value;
		} else {
			return true;
		}
	}

}